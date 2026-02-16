const express = require('express');
const multer = require('multer');
const { v4: uuidv4 } = require('uuid');
const helmet = require('helmet');
const rateLimit = require('express-rate-limit');
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = process.env.PORT || 3000;

// 🔒 SECURITY HEADERS
app.use(helmet());

// 📊 RATE LIMIT - 5 uploads/hora
const uploadLimiter = rateLimit({
  windowMs: 60 * 60 * 1000,
  max: 5,
  message: { error: 'Limite: 5 uploads/hora' }
});

// 📊 RATE LIMIT geral
const reqLimiter = rateLimit({
  windowMs: 15 * 60 * 1000,
  max: 100
});

app.use(reqLimiter);

// 📁 Static files + JSON
app.use(express.static('public'));
app.use(express.json({ limit: '50mb' }));
app.use('/uploads', express.static('uploads'));

// 💾 STORAGE com UUID
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    const dir = 'uploads';
    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
    cb(null, dir);
  },
  filename: (req, file, cb) => {
    cb(null, `${uuidv4()}${path.extname(file.originalname)}`);
  }
});

const upload = multer({
  storage,
  limits: { fileSize: 512 * 1024 * 1024 }, // 512MB
  fileFilter: (req, file, cb) => {
    const allowed = ['.apk', '.ipa', '.zip', '.pdf', '.mp4', '.exe'];
    if (allowed.includes(path.extname(file.originalname).toLowerCase())) {
      cb(null, true);
    } else {
      cb(new Error('Tipo inválido'), false);
    }
  }
});

// 📱 ROTAS
app.get('/', (req, res) => res.sendFile(path.join(__dirname, 'public', 'index.html')));
app.get('/download/:id', (req, res) => {
  const fileId = req.params.id;
  const filePath = path.join('uploads', fileId);
  
  if (!fs.existsSync(filePath)) {
    return res.sendFile(path.join(__dirname, 'public', '404.html'));
  }
  
  res.sendFile(path.join(__dirname, 'public', 'download.html'));
});

// ✅ UPLOAD
app.post('/upload', uploadLimiter, upload.single('file'), (req, res) => {
  if (!req.file) return res.status(400).json({ error: 'Arquivo inválido' });
  
  const url = `https://${req.get('host')}/uploads/${req.file.filename}`;
  res.json({
    success: true,
    download: `/download/${req.file.filename}`,
    direct: url,
    filename: req.file.filename,
    size: Math.round(req.file.size / 1024 / 1024 * 100) / 100 + 'MB'
  });
});

// 404
app.use((req, res) => res.status(404).sendFile(path.join(__dirname, 'public', '404.html')));

app.listen(PORT, () => {
  console.log(`🌟 DarkApps v3.0: https://darkapps.up.railway.app`);
});

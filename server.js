const express = require('express');
const multer = require('multer');
const fs = require('fs-extra');
const path = require('path');
const app = express();

app.set('view engine', 'ejs');
app.use(express.static('public'));
app.use(express.urlencoded({ extended: true }));

// STORAGE 512MB RAILWAY
const UPLOAD_DIR = path.join(__dirname, 'public/uploads');
fs.ensureDirSync(UPLOAD_DIR);

const storage = multer.diskStorage({
  destination: (req, file, cb) => cb(null, UPLOAD_DIR),
  filename: (req, file, cb) => {
    const unique = Date.now() + '-' + Math.round(Math.random() * 1E9);
    cb(null, file.fieldname + '-' + unique + path.extname(file.originalname));
  }
});
const upload = multer({ 
  storage, 
  limits: { fileSize: 512 * 1024 * 1024 } // 512MB
});

// HOME
app.get('/', (req, res) => {
  res.render('index', { files: getFiles() });
});

// UPLOAD
app.post('/upload', upload.single('file'), (req, res) => {
  res.redirect('/');
});

// DOWNLOAD + TIMER + ADS
app.get('/dl/:id', (req, res) => {
  const file = getFile(req.params.id);
  if (!file) return res.status(404).send('404');
  res.render('dl', { file });
});

app.get('/download/:id', (req, res) => {
  const file = getFile(req.params.id);
  if (!file) return res.status(404).send('404');
  res.download(path.join(UPLOAD_DIR, file.filename));
});

function getFiles() {
  return fs.readdirSync(UPLOAD_DIR).map(f => ({
    id: f.split('-')[0],
    name: f,
    size: (fs.statSync(path.join(UPLOAD_DIR, f)).size / 1024 / 1024).toFixed(1) + 'MB',
    date: fs.statSync(path.join(UPLOAD_DIR, f)).mtime
  }));
}

function getFile(id) {
  const files = getFiles();
  return files.find(f => f.id === id);
}

app.listen(8080, () => {
  console.log('🚀 DarkApps Railway: http://localhost:8080');
});

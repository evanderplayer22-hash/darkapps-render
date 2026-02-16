<?php
session_start();
if (!is_dir('uploads')) mkdir('uploads', 0777, true);
if (!is_dir('data')) mkdir('data', 0777, true);

if (isset($_POST['upload']) && isset($_FILES['file'])) {
    $target = "uploads/" . uniqid() . "_" . $_FILES['file']['name'];
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        $id = substr(md5(time() . rand()), 0, 8);
        $data = [
            'name' => $_FILES['file']['name'],
            'path' => $target,
            'size' => $_FILES['file']['size'],
            'views' => 0,
            'downloads' => 0,
            'created' => date('Y-m-d H:i:s'),
            'earnings' => 0.0
        ];
        file_put_contents("data/$id.json", json_encode($data));
        $_SESSION['success'] = "✅ Upload OK! Ganhe R$0,15 por download";
        $_SESSION['link'] = "https://" . $_SERVER['HTTP_HOST'] . "/dl.php?id=$id";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔥 DarkApps - APKs Premium R$0,15/DL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #16213e 100%);
            color: #00ff88; 
            font-family: 'Courier New', monospace; 
            min-height: 100vh;
            overflow-x: hidden;
        }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .header { 
            text-align: center; 
            padding: 40px 0; 
            background: rgba(0,255,136,0.1); 
            border-bottom: 3px solid #00ff88;
            margin-bottom: 40px;
            border-radius: 20px;
            box-shadow: 0 0 50px rgba(0,255,136,0.3);
        }
        h1 { font-size: 3.5em; text-shadow: 0 0 30px #00ff88; margin-bottom: 10px; }
        .subtitle { font-size: 1.4em; opacity: 0.9; }
        .upload-box { 
            background: rgba(0,0,0,0.85); 
            padding: 50px; 
            margin: 30px 0; 
            border: 3px solid #00ff88; 
            border-radius: 25px; 
            box-shadow: 0 20px 60px rgba(0,255,136,0.2);
            backdrop-filter: blur(10px);
        }
        .upload-title { text-align: center; font-size: 2.2em; margin-bottom: 40px; }
        input[type="file"] { 
            width: 100%; 
            padding: 25px; 
            font-size: 18px; 
            background: #111; 
            color: #00ff88; 
            border: 3px solid #00ff88; 
            border-radius: 15px;
            margin-bottom: 30px;
            transition: all 0.3s;
        }
        input[type="file"]:hover { box-shadow: 0 0 30px rgba(0,255,136,0.5); }
        .btn { 
            background: linear-gradient(45deg, #00ff88, #00cc6a); 
            color: #000; 
            padding: 25px 60px; 
            font-size: 22px; 
            border: none; 
            border-radius: 50px; 
            cursor: pointer; 
            font-weight: bold; 
            display: block; 
            margin: 0 auto;
            box-shadow: 0 15px 40px rgba(0,255,136,0.4);
            transition: all 0.3s;
        }
        .btn:hover { transform: translateY(-5px) scale(1.05); box-shadow: 0 25px 60px rgba(0,255,136,0.6); }
        .success { 
            background: rgba(0,255,0,0.2); 
            border: 3px solid #00ff88; 
            padding: 30px; 
            margin: 30px 0; 
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 0 40px rgba(0,255,0,0.4);
        }
        .success-link { 
            color: #00ff88; 
            font-size: 20px; 
            word-break: break-all;
            background: rgba(0,0,0,0.5);
            padding: 15px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 15px;
        }
        @media (max-width: 768px) {
            h1 { font-size: 2.5em; }
            .upload-box { padding: 30px 20px; }
            .btn { padding: 20px 40px; font-size: 18px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔥 DARKAPPS</h1>
            <p class="subtitle">APKs Premium • MP4 • ZIP • R$0,15 por Download + R$0,05 por View</p>
        </div>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success">
                <?= $_SESSION['success'] ?>
                <?php if (isset($_SESSION['link'])): ?>
                    <br><strong>🔗 LINK DO SEU ARQUIVO:</strong><br>
                    <a href="<?= $_SESSION['link'] ?>" target="_blank" class="success-link"><?= $_SESSION['link'] ?></a>
                <?php endif; ?>
            </div>
            <?php unset($_SESSION['success'], $_SESSION['link']); ?>
        <?php endif; ?>
        
        <div class="upload-box">
            <h2 class="upload-title">📤 UPLOAD GRATUITO</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="file" required accept=".apk,.zip,.rar,.mp4,.mp3,.exe,.pdf">
                <br><br>
                <button type="submit" name="upload" class="btn">🚀 ENVIAR ARQUIVO</button>
            </form>
        </div>
    </div>
</body>
</html>

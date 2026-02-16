<!DOCTYPE html>
<html>
<head>
    <title>🔥 DarkApps - APKs Premium Grátis</title>
    <meta name="viewport" content="width=device-width">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:Arial}
        body{background:linear-gradient(45deg,#1a1a2e,#16213e,#0f3460);color:#fff;min-height:100vh;padding:20px}
        .container{max-width:800px;margin:0 auto}
        h1{text-align:center;font-size:2.5em;margin-bottom:20px;text-shadow:0 0 20px #00f5ff}
        .upload-form{background:rgba(255,255,255,0.1);padding:30px;border-radius:20px;backdrop-filter:blur(10px);margin-bottom:40px}
        input[type=file]{width:100%;padding:15px;border:none;border-radius:10px;background:#333;color:#fff;font-size:16px;margin-bottom:15px}
        button{width:100%;padding:15px;background:linear-gradient(45deg,#ff6b6b,#feca57);border:none;border-radius:10px;color:#fff;font-size:18px;font-weight:bold;cursor:pointer;transition:all 0.3s}
        button:hover{transform:scale(1.05);box-shadow:0 10px 30px rgba(255,107,107,0.4)}
        .files{list-style:none}
        .file{display:flex;justify-content:space-between;align-items:center;background:rgba(255,255,255,0.1);padding:20px;margin:10px 0;border-radius:15px;backdrop-filter:blur(10px)}
        .file a{color:#00f5ff;text-decoration:none;font-weight:bold;font-size:18px}
        .file span{color:#ccc}
        .stats{text-align:center;margin:30px 0;font-size:24px;background:rgba(0,255,255,0.1);padding:20px;border-radius:15px}
        @media(max-width:600px){.container{padding:10px}h1{font-size:2em}}
    </style>
    <!-- POPADS -->
    <script type="text/javascript" src="//www.popads.net/pop.js"></script>
    <script type="text/javascript" src="//ap.lijit.com/www/delivery/fpi.js?z=1234567"></script>
</head>
<body>
    <div class="container">
        <h1>🔥 DarkApps Railway</h1>
        <div class="stats">
            📁 <%= files.length %> arquivos | 💾 512MB free
        </div>
        
        <form class="upload-form" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" accept=".apk,.mp3,.mp4,.zip,.rar" required>
            <button type="submit">🚀 UPLOAD AGORA (512MB Max)</button>
        </form>
        
        <h2>📱 Downloads:</h2>
        <% files.forEach(file => { %>
            <div class="file">
                <a href="/dl/<%= file.id %>">📥 <%= file.name %></a>
                <span><%= file.size %> - <%= file.date.toLocaleDateString('pt-BR') %></span>
            </div>
        <% }) %>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Download - <%= file.name %></title>
    <meta name="viewport" content="width=device-width">
    <style>
        body{background:linear-gradient(45deg,#1a1a2e,#16213e);color:#fff;font-family:Arial;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .card{background:rgba(255,255,255,0.1);padding:40px;border-radius:20px;backdrop-filter:blur(20px);text-align:center;max-width:500px;width:100%;box-shadow:0 20px 40px rgba(0,0,0,0.3)}
        h1{font-size:2.5em;margin-bottom:20px;text-shadow:0 0 20px #00f5ff}
        .file-info{margin:30px 0;font-size:1.3em;color:#00f5ff}
        .timer{display:flex;align-items:center;justify-content:center;font-size:3em;font-weight:bold;margin:30px 0;color:#ff6b6b;text-shadow:0 0 20px #ff6b6b}
        .download-btn{display:block;width:100%;padding:20px;background:linear-gradient(45deg,#00f5ff,#0099cc);border:none;border-radius:15px;color:#000;font-size:1.5em;font-weight:bold;margin-top:30px;cursor:pointer;transition:all 0.3s;text-decoration:none}
        .download-btn:hover{transform:scale(1.05);box-shadow:0 15px 35px rgba(0,245,255,0.4)}
        .ads{margin:20px 0;padding:20px;background:rgba(255,255,255,0.05);border-radius:10px}
        @media(max-width:600px){.card{padding:30px}}
    </style>
</head>
<body>
    <div class="card">
        <h1>⏳ Aguarde Download</h1>
        <div class="file-info">
            📁 <strong><%= file.name %></strong><br>
            📊 <%= file.size %>
        </div>
        
        <!-- ADS OBRIGATÓRIOS -->
        <div class="ads">
            <script type="text/javascript" src="//www.popads.net/pop.js"></script>
            <iframe src="https://www.popads.net/ads.php" width="100%" height="200" frameborder="0"></iframe>
        </div>
        
        <div class="timer" id="timer">15</div>
        <a href="/download/<%= file.id %>" class="download-btn" id="downloadBtn" style="pointer-events:none">📥 BAIXAR AGORA</a>
    </div>

    <script>
        let time = 15;
        const timer = document.getElementById('timer');
        const btn = document.getElementById('downloadBtn');
        
        const interval = setInterval(() => {
            time--;
            timer.textContent = time;
            if (time <= 0) {
                clearInterval(interval);
                btn.style.pointerEvents = 'auto';
                btn.innerHTML = '🚀 DOWNLOAD RÁPIDO!';
            }
        }, 1000);
    </script>
</body>
</html>

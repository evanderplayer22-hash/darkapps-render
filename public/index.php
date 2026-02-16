<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DarkApps - APK & Files</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;}
        .container{background:white;padding:40px;border-radius:20px;box-shadow:0 20px 40px rgba(0,0,0,0.1);max-width:500px;width:100%;text-align:center;}
        h1{color:#333;margin-bottom:10px;font-size:2.5em;}
        .subtitle{color:#666;margin-bottom:30px;}
        .upload-box{border:3px dashed #667eea;border-radius:15px;padding:40px 20px;margin:30px 0;cursor:pointer;transition:all .3s;background:#f8f9ff;}
        .upload-box:hover{border-color:#764ba2;background:#f0f0ff;transform:translateY(-5px);}
        .upload-icon{font-size:4em;margin-bottom:15px;}
        input[type=file]{display:none;}
        .btn{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:white;padding:15px 40px;border:none;border-radius:25px;font-size:1.1em;cursor:pointer;transition:all .3s;text-decoration:none;display:inline-block;}
        .btn:hover{transform:translateY(-2px);box-shadow:0 10px 20px rgba(102,126,234,0.3);}
        .result{margin-top:20px;padding:20px;border-radius:10px;display:none;}
        .success{background:#d4edda;color:#155724;border:1px solid #c3e6cb;}
        .error{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;}
        #fileInfo{margin:20px 0;color:#666;min-height:20px;}
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 DarkApps</h1>
        <p class="subtitle">Upload APKs, Apps, ZIPs, PDFs (512MB máx)</p>
        
        <div class="upload-box" onclick="fileInput.click()">
            <div class="upload-icon">📱</div>
            <div>Arraste ou clique aqui</div>
            <div style="color:#888;font-size:0.9em;">5 uploads/hora • UUID seguro</div>
        </div>
        
        <input type="file" id="fileInput" accept=".apk,.ipa,.zip,.pdf,.mp4">
        <div id="fileInfo"></div>
        <button class="btn" id="uploadBtn" onclick="uploadFile()" disabled>🚀 Upload</button>
        
        <div id="result" class="result"></div>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const uploadBtn = document.getElementById('uploadBtn');
        const result = document.getElementById('result');
        const uploadBox = document.querySelector('.upload-box');

        // Drag & Drop
        ['dragenter','dragover','dragleave','drop'].forEach(e=>uploadBox.addEventListener(e,ev=>ev.preventDefault()));
        uploadBox.addEventListener('dragover',()=>uploadBox.style.borderColor='#2196f3');
        uploadBox.addEventListener('dragleave',()=>uploadBox.style.borderColor='#667eea');
        uploadBox.addEventListener('drop',e=>{if(e.dataTransfer.files[0])handleFile(e.dataTransfer.files[0]);});
        
        fileInput.onchange = e=>e.target.files[0]&&handleFile(e.target.files[0]);

        function handleFile(file){
            if(file.size>512*1024*1024){
                fileInfo.innerHTML='<span style="color:red">❌ 512MB máximo</span>';
                return;
            }
            fileInfo.innerHTML=`✅ ${file.name} (${Math.round(file.size/1024/1024)}MB)`;
            uploadBtn.disabled=false;
        }

        async function uploadFile(){
            const file = fileInput.files[0];
            const formData = new FormData();
            formData.append('file',file);

            uploadBtn.innerHTML='⏳ Upload...'; uploadBtn.disabled=true;
            
            try{
                const res = await fetch('/upload',{method:'POST',body:formData});
                const data = await res.json();
                
                if(data.success){
                    result.innerHTML=`
                        ✅ <strong>Upload concluído!</strong><br>
                        📱 <a href="${data.download}" target="_blank">🔥 Link monetizado</a><br>
                        📥 <a href="${data.direct}" target="_blank">💾 Download direto</a><br>
                        <small>${data.filename} • ${data.size}</small>
                    `;
                    result.className='result success'; result.style.display='block';
                }else{
                    result.innerHTML=`❌ ${data.error}`; result.className='result error'; result.style.display='block';
                }
            }catch(e){
                result.innerHTML='❌ Erro de conexão'; result.className='result error'; result.style.display='block';
            }
            
            uploadBtn.innerHTML='🚀 Upload'; uploadBtn.disabled=false;
            fileInput.value=''; fileInfo.innerHTML='';
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Controle JEDI-API</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 20px; background: #f0f2f5; color: #333; }
        .container { max-width: 900px; margin: auto; }
        h1 { text-align: center; color: #1a73e8; }
        .route-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 20px; border-left: 5px solid #a142f4; }
        .route-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .method-badge { padding: 4px 10px; border-radius: 4px; color: white; font-weight: bold; font-size: 0.8em; background: #a142f4; }
        label { display: block; margin-bottom: 8px; font-weight: bold; font-size: 0.9em; color: #5f6368; }
        textarea { width: 100%; height: 80px; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background: #fff; font-family: 'Consolas', monospace; resize: vertical; box-sizing: border-box; margin-bottom: 10px; }
        input[type="file"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; background: #fafafa; margin-bottom: 10px; }
        button { width: 100%; padding: 12px; cursor: pointer; border: none; border-radius: 6px; color: white; font-weight: bold; transition: 0.3s; background: #a142f4; }
        button:hover { background: #8b37d3; box-shadow: 0 4px 12px rgba(161, 66, 244, 0.2); }
        pre { background: #202124; color: #34a853; padding: 15px; border-radius: 8px; overflow-x: auto; min-height: 150px; border: 1px solid #3c4043; margin-top: 20px; font-family: 'Consolas', monospace; }
    </style>
</head>
<body>

<div class="container">
    <h1>🛠 JEDI-API Control Panel</h1>

    <div class="route-card">
        <div class="route-header">
            <strong>/system_user/validar</strong>
            <span class="method-badge">POST</span>
        </div>
        <textarea id="textLogin" placeholder='{"email": "cpassos.cp2@gmail.com", "senha": "..."}'></textarea>
        <input type="file" id="fileLogin" accept=".json">
        <button onclick="testarRota('system_user/validar', 'fileLogin', 'textLogin')">Executar Login</button>
    </div>

    <div class="route-card">
        <div class="route-header">
            <strong>/partidasperguntas/ranking</strong>
            <span class="method-badge">POST</span>
        </div>
        <textarea id="textRanking" placeholder='{"id": 1, "usuario": "Claudio"}'></textarea>
        <input type="file" id="fileRanking" accept=".json">
        <button onclick="testarRota('partidasperguntas/ranking', 'fileRanking', 'textRanking')">Consultar Ranking</button>
    </div>

    <h3>📡 Console de Saída:</h3>
    <pre id="resultado">Aguardando...</pre>
</div>

<script>
    const URL_BASE = 'http://localhost/JEDI-API';

    async function dispararAPI(rota, dados) {
        const resBox = document.getElementById('resultado');
        resBox.innerText = "⏳ Enviando POST...";

        try {
            const response = await fetch(`${URL_BASE}/${rota}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const text = await response.text();
            try {
                const json = JSON.parse(text);
                resBox.innerText = JSON.stringify(json, null, 4);
                resBox.style.color = "#34a853";
            } catch (e) {
                resBox.innerText = "❌ Resposta não é JSON. Erro no PHP:\n\n" + text;
                resBox.style.color = "#ff6b6b";
            }
        } catch (error) {
            resBox.innerText = "❌ Erro de Conexão. Verifique se o Apache está ligado e o CORS ativo.";
            resBox.style.color = "#ff6b6b";
        }
    }

    function testarRota(rota, inputId, textId) {
        const fileInput = document.getElementById(inputId);
        const textArea = document.getElementById(textId);

        if (textArea.value.trim() !== "") {
            try {
                dispararAPI(rota, JSON.parse(textArea.value));
            } catch (e) { alert("JSON digitado está inválido!"); }
        } else if (fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => dispararAPI(rota, JSON.parse(e.target.result));
            reader.readAsText(fileInput.files[0]);
        } else {
            alert("Preencha o campo de texto ou selecione um arquivo.");
        }
    }
</script>
</body>
</html>
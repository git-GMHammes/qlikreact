<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Exemplo de Eventos de Mouse com Arrow Functions</title>
    <style>
        .area {
            width: 200px;
            height: 200px;
            margin: 20px;
            background-color: #f0f0f0;
            display: inline-block;
            position: relative;
        }
    </style>
</head>

<body>
    <h1>Teste Eventos de Mouse</h1>
    <a href="https://docs.google.com/document/d/1WoSX0gT7_8Jra4yF0MiD29JeeC0taIuMCIFShq-hgjk/edit?usp=sharing"
        target="_blank" rel="Resumo no Google">Resumo no Google</a>
    <div class="area1 area"></div>
    <p class="log">Eventos serão exibidos aqui.</p>

    <script>
        const area = document.querySelector('.area1');
        const log = document.querySelector('.log');

        area.addEventListener('click', event => {
            updateLog('Clicado');
        });

        area.addEventListener('dblclick', event => {
            updateLog('Duplo clique');
        });

        area.addEventListener('mousedown', event => {
            updateLog('Mouse pressionado');
        });

        area.addEventListener('mouseup', event => {
            updateLog('Mouse solto');
        });

        area.addEventListener('mousemove', event => {
            updateLog(`Mouse move em x: ${event.clientX}, y: ${event.clientY}`);
        });

        area.addEventListener('mouseover', event => {
            updateLog('Mouse sobre a área');
        });

        area.addEventListener('mouseout', event => {
            updateLog('Mouse fora da área');
        });

        area.addEventListener('mouseenter', event => {
            updateLog('Mouse entrou na área');
        });

        area.addEventListener('mouseleave', event => {
            updateLog('Mouse saiu da área');
        });

        function updateLog(message) {
            log.textContent = message;
            console.log(message);
        }
    </script>
</body>

</html>
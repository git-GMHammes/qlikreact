<?php
$parametros_backend = array(
    'request_scheme' => $_SERVER['REQUEST_SCHEME'],
    'server_name' => $_SERVER['SERVER_NAME'],
    'server_port' => $_SERVER['SERVER_PORT'],
);
?>

<button class="botaoClique">Clique Aqui</button>

<p class="textoParaMudar">Texto original</p>

<script>
    document.querySelector('.botaoClique').addEventListener('click', () => {
        document.querySelector('.textoParaMudar').textContent = "Texto alterado!";
    });
</script>

<p class="mensagem">Aguarde...</p>

<script>
    setTimeout(() => {
        document.querySelector('.mensagem').textContent = "A operação foi concluída!";
    }, 3000); // Aguarda 3 segundos antes de executar
</script>

<ul class="listaQuadrados"></ul>

<script>
    const numeros = [1, 2, 3, 4, 5];
    const quadrados = numeros.map(num => num * num);

    quadrados.forEach(q => {
        const li = document.createElement('li');

        li.textContent = q;
        document.querySelector('listaQuadrados').appendChild(li);
    });
</script>

<div class="App_listar_etapa" data-result='<?php echo json_encode($parametros_backend); ?>'></div>

<script type="text/babel">
    const AllListaEtapa = () => {

    }
</script>
<?php
myPrint($metadata['getURI'], 'src\app\Views\qlikreact\licitacao_etapa\listar.php');
$parametros_backend = array(
    'request_scheme' => $_SERVER['REQUEST_SCHEME'],
    'server_name' => $_SERVER['SERVER_NAME'],
    'server_port' => $_SERVER['SERVER_PORT'],
    'route_api_001' => 'qlikreact/etapa/api/listar',
    'getURI' => isset($metadata['getURI']) ? ($metadata['getURI']) : (array())
); 
?>

<div class="App_lista_licitacao_etapa" data-result="<?php echo json_encode($parameter_backend); ?>"></div>

<script type="text/babel">
    const AppListaLicitacaoEtapa = () => {
        // Variáveis do Backend
        const parametros = JSON.parse(document.querySelector('.App_lista_licitacao_etapa').getAttribute('data-result'));
        const request_scheme = parametros.request_scheme;
        const server_name = parametros.server_name;
        const server_port = parametros.server_port;
        const route_api_001 = parametros.route_api_001;
        const getURI = parametros.getURI;

    };
    ReactDOM.render(<AppListaLicitacaoEtapa />, document.querySelector('.App_lista_licitacao_etapa'));
</script>
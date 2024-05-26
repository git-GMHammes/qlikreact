<?php
$getURI = isset($metadata['getURI']) ? $metadata['getURI'] : (array());
$parametros_backend = array(
    'route_api_001' => 'qlikreact/etapa/api/listar',
    'DEBUG_MY_PRINT' => false,
    'request_scheme' => $_SERVER['REQUEST_SCHEME'],
    'server_name' => $_SERVER['SERVER_NAME'],
    'server_port' => $_SERVER['SERVER_PORT'],
    'getURI' => isset($metadata['getURI']) ? ($metadata['getURI']) : (array())
);
?>

<div class="App_listar_etapa" data-result='<?php echo json_encode($parametros_backend); ?>'></div>

<script type="text/babel">
    const AllListaEtapa = () => {

        // Variáveis recebidas do Backend
        const parametros = JSON.parse(document.querySelector('.App_listar_etapa').getAttribute('data-result'));
        // console.log('Parametros do Backends: ', parametros);
        const request_scheme = parametros.request_scheme;
        const server_name = parametros.server_name;
        const server_port = parametros.server_port;
        const route_api_001 = parametros.route_api_001;
        const getURI = parametros.getURI;
        // console.log('Parâmentros da URI: ', getURI);
        const url_api_001 = `${request_scheme}://${server_name}:${server_port}/${route_api_001}`;
        // console.log('API (GET): ', url_api_001);

        // Variáveis do react
        const [loading, setLoading] = React.useState(true);
        const [error, setError] = React.useState(null);
        const [etapa, setEtapa] = React.useState([]);
        const [carinha, setCarinha] = React.useState([]);

        React.useEffect(() => {
            fetch(url_api_001)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            setError(`Falha na resposta do servidor: ${response.status} ${response.statusText} - Detalhes: ${JSON.stringify(errorData)}`);
                            setLoading(false);
                        }).catch(() => {
                            setError(`Erro ${response.status}: ${response.statusText} - Não foi possível obter mais detalhes do erro. URL: ${url_api_001}`);
                            setLoading(false);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.result) {
                        setEtapa(data.result);
                    } else {
                        setError('Formato de dados inválido ou vazio.');
                    }
                    setLoading(false);
                })
                .catch(err => {
                    console.error('Erro ao buscar dados:', err);
                    setError(err.toString());
                    setLoading(false);
                });
        }, []);

        // Verificação de carregamento
        if (loading) {
            return (
                <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', height: '100vh' }}>
                    <div style={{
                        width: '40px',
                        height: '40px',
                        border: '5px solid #f3f3f3',
                        borderTop: '5px solid #3498db',
                        borderRadius: '50%',
                        animation: 'spin 2s linear infinite'
                    }} />
                    <style>
                        {`
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                `}
                    </style>
                    &emsp;Carregando...
                </div>
            );
        }

        if (error) {
            return <div>Erro ao carregar dados: {error}</div>;
        }

        return (
            <div>
                <div>
                    <h2>Lista de Etapas</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    Ordem
                                </th>
                                <td>
                                    Nº
                                </td>

                                <th>
                                    Estragio Atual<br />
                                    Estágio
                                </th>
                                <th>
                                    Sigla<br />
                                    Acrônimo
                                </th>
                                <th>
                                    Rótulo<br />
                                    Segundo Rotulo
                                </th>
                                <th>
                                    Termo interno<br />
                                    Padrão interno
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {etapa.map((item, index) => (
                                <tr key={index}>
                                    <td>{item.order}</td>
                                    <td>{item.pk_stage}</td>
                                    <td>{item.stage}</td>
                                    <td>{item.str_acronym}</td>
                                    <td>{item.str_label}</td>
                                    <td>{item.int_standard_term}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
                <pre>
                    {JSON.stringify(etapa, null, 2)}
                </pre>
                <div>
                    {etapa.map((item, index) => (
                        <div key={index}>{item.pk_stage}</div>
                    ))}
                </div>
            </div >
        );
    };
    ReactDOM.render(<AllListaEtapa />, document.querySelector('.App_listar_etapa'));
</script>
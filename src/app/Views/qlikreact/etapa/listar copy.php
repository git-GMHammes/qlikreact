<?php
$getURI = isset($metadata['getURI']) ? $metadata['getURI'] : (array());
$parametros_backend = array(
    'request_scheme' => $_SERVER['REQUEST_SCHEME'],
    'server_name' => $_SERVER['SERVER_NAME'],
    'server_port' => $_SERVER['SERVER_PORT'],
    'route_api_001' => 'qlikreact/etapa/api/listar',
    'getURI' => $getURI
);
?>

<div class="App_listar_etapa" data-result='<?php echo json_encode($parametros_backend); ?>'></div>

<script type="text/babel">
    const AllListaEtapa = () => {

        // Variáveis recebidas do Backend
        const parametros = JSON.parse(document.querySelector('.App_listar_etapa').getAttribute('data-result'));
        const url_api_001 = `${parametros.request_scheme}://${parametros.server_name}:${parametros.server_port}/${parametros.route_api_001}`;

        // Variáveis do react
        const [loading, setLoading] = React.useState(true);
        const [error, setError] = React.useState(null);
        const [etapa, setEtapa] = React.useState([]);

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
                <h2>Lista de Etapas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nº</th>
                        </tr>
                    </thead>
                    <tbody>
                        {etapa.map((item, index) => (
                            <tr key={index}>
                                <td>{item.pk_stage}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        );
    };

    ReactDOM.render(<AllListaEtapa />, document.querySelector('.App_listar_etapa'));
</script>
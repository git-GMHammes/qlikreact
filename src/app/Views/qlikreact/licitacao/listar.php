<?php
$parametros_backend = array(
    'route_api_001' => 'index.php/qlikreact/licitacao/api/listar',
    'route_api_002' => 'index.php/qlikreact/licitacao/api/ordem',
    'route_api_003' => 'index.php/qlikreact/licitacao_etapa/api/listar_licitacao',
    'DEBUG_MY_PRINT' => false,
    'request_scheme' => $_SERVER['REQUEST_SCHEME'],
    'server_name' => $_SERVER['SERVER_NAME'],
    'server_port' => $_SERVER['SERVER_PORT'],
    'getURI' => isset($metadata['getURI']) ? ($metadata['getURI']) : (array())
);
// myPrint($parametros_backend, '');
?>

<div class="App_listar_licitacao" data-result='<?php echo json_encode($parametros_backend); ?>'></div>

<script type="text/babel">
    const AppListaLicitacao = () => {
        // Variáveis recebidas do Backend
        const parametros = JSON.parse(document.querySelector('.App_listar_licitacao').getAttribute('data-result'));
        // Prepara as Variáveis do REACT recebidas pelo BACKEND
        const request_scheme = parametros.request_scheme;
        const server_name = parametros.server_name;
        const server_port = parametros.server_port;
        const route_api_001 = parametros.route_api_001;
        const route_api_002 = parametros.route_api_002;
        const route_api_003 = parametros.route_api_003;
        const getURI = parametros.getURI;
        const debugMyPrint = parametros.DEBUG_MY_PRINT;
        // Monta as APIs
        const url_api_001 = `${request_scheme}://${server_name}:${server_port}/${route_api_001}`;
        console.log("URL API 001:", url_api_001);
        const url_post_002 = `${request_scheme}://${server_name}:${server_port}/${route_api_002}`;
        console.log("URL POST 002:", url_post_002);
        const url_post_003 = `${request_scheme}://${server_name}:${server_port}/${route_api_003}`;
        console.log("URL POST 003:", url_post_003);
        // Variáveis do React
        const [processos, setProcessos] = React.useState([]);
        const [smilesLicitacao, setSmilesLicitacao] = React.useState({});
        const [loading, setLoading] = React.useState(true);
        const [error, setError] = React.useState(null);
        const [dragIndex, setDragIndex] = React.useState(-1);

        React.useEffect(() => {
            fetch(url_api_001)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Network response was not ok (${response.status})`);
                    }
                    return response.json();
                })
                .then(data => {
                    setProcessos(data.result.listar_licitacao);
                    setLoading(false);
                    // Após carregar os processos, busca os smiles para cada licitação
                    data.result.listar_licitacao.forEach(licitacao => {
                        fetchDetails(licitacao.pk_bidding);
                    });
                })
                .catch(error => {
                    setError(error.toString());
                    setLoading(false);
                });
        }, []);

        const fetchDetails = (pkBidding) => {
            const urlSmiles = `${url_post_003}/${pkBidding}`;
            fetch(urlSmiles)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Network response was not ok (${response.status})`);
                    }
                    return response.json();
                })
                .then(data => {
                    const statusMade = {};
                    data.result.forEach(item => {
                        statusMade[item.ID] = item.made;
                    });
                    setSmilesLicitacao(prev => ({ ...prev, [pkBidding]: statusMade }));
                })
                .catch(error => {
                    console.error('Erro ao buscar smiles da licitação:', error);
                });
        };

        function renderStatusIcon(statusMade) {
            if (!statusMade) return null; 
            return Object.values(statusMade).map((made, idx) => (
                <span key={idx}>
                    {made === 'Y' ? <button type="button" className="btn btn-outline-success"><i className="bi bi-emoji-smile-fill"></i></button> :
                        made === 'N' ? <button type="button" className="btn btn-outline-danger"><i className="bi bi-emoji-frown-fill"></i></button> :
                            <button type="button" className="btn btn-outline-warning"><i className="bi bi-emoji-neutral-fill"></i></button>}
                </span>
            ));
        }

        const onDragStart = (e, index) => {
            setDragIndex(index);
        };

        const onDragOver = (e) => {
            e.preventDefault();
        };

        const onDrop = (e, dropIndex) => {
            e.preventDefault();
            const updatedProcessos = [...processos];
            const draggedItem = updatedProcessos.splice(dragIndex, 1)[0];
            updatedProcessos.splice(dropIndex, 0, draggedItem);
            setProcessos(updatedProcessos);
            submitNewOrder(updatedProcessos);
        };

        const submitNewOrder = (updatedProcessos) => {
            const formData = new URLSearchParams();
            updatedProcessos.forEach((processo, index) => {
                formData.append('setFormOrder[]', `${index + 1}|${processo.pk_bidding}`);
            });
            fetch(url_post_001, {
                method: 'POST',
                body: formData,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(response => response.text())
                .then(data => {
                    if (debugMyPrint) {
                        console.log("Submit response V2:", data.result);
                    }
                })
                .catch(error => {
                    console.error('Erro ao enviar dados:', error);
                });
        };

        // Verificação de carregamento
        if (loading) {
            return <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', height: '100vh' }}>
                <div style={{
                    width: '40px',
                    height: '40px',
                    border: '5px solid #f3f3f3',
                    borderTop: '5px solid #3498db',
                    borderRadius: '50%',
                    animation: 'spin 2s linear infinite'
                }} />
                <style>{`
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                `}</style>
                &emsp;Carregando...
            </div>;
        }

        if (error) {
            return <div>Erro ao carregar dados: {error}</div>;
        }

        return (
            <div className="container">
                <h2>Lista de Processos Licitatórios</h2>
                <form onSubmit={(e) => e.preventDefault()}>
                    {/*
                         Esta linha previne o comportamento padrão do formulário, que é enviar e recarregar a página.
                         Ao chamar e.preventDefault(), o envio do formulário não causará o recarregamento da página,
                         permitindo que a interação aconteça sem interrupções e mantendo o estado do aplicativo.
                    */}
                    <table className="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Chave da Licitação</th>
                                <th>No Prazo</th>
                                <th>Status</th>
                                <th>Processo Eletrônico SEI</th>
                            </tr>
                        </thead>
                        <tbody>
                            {processos.map((processo, index) => (
                                <tr key={index}>
                                    <td>
                                        <i className="bi bi-grip-vertical" draggable="true"
                                            // Atributo onDragStart associado ao ícone, iniciado quando um drag (arraste) começa.
                                            onDragStart={(e) => onDragStart(e, index)}
                                            // Atributo onDragOver que é chamado sempre que um item arrastado passa sobre um possível local de soltura.
                                            onDragOver={onDragOver}
                                            // Atributo onDrop que é chamado quando um item é solto sobre o elemento. Este evento finaliza o processo de arrastar e soltar.
                                            onDrop={(e) => onDrop(e, index)}>
                                        </i>
                                    </td>
                                    <td>{index + 1}</td>
                                    <td>{processo.bidding}</td>
                                    <td>{processo.not_fulfilled === 'Y' ? 'Sim' : 'Não'}</td>
                                    <td>{renderStatusIcon(smilesLicitacao[processo.pk_bidding])}</td>
                                    <td>{processo.sei}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    {debugMyPrint && <pre>{JSON.stringify(processos, null, 2)}</pre>}
                </form>
            </div>
        );
    };

    ReactDOM.render(<AppListaLicitacao />, document.querySelector('.App_listar_licitacao'));
</script>
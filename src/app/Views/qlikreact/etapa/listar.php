<?php
$getURI = isset($metadata['getURI']) ? $metadata['getURI'] : (array());
$parametros_backend = array(
    'route_api_001' => 'qlikreact/etapa/api/listar',
    'route_api_002' => 'qlikreact/etapa/api/ordem',
    'DEBUG_MY_PRINT' => true,
    'request_scheme' => $_SERVER['REQUEST_SCHEME'],
    'server_name' => $_SERVER['SERVER_NAME'],
    'server_port' => $_SERVER['SERVER_PORT'],
    'getURI' => isset($metadata['getURI']) ? ($metadata['getURI']) : (array())
);
// myPrint($parametros_backend, '');
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
        const route_api_002 = parametros.route_api_002;
        const getURI = parametros.getURI;
        const debugMyPrint = parametros.DEBUG_MY_PRINT;
        const url_api_001 = `${request_scheme}://${server_name}:${server_port}/${route_api_001}`;
        console.log('URL API 001: ', url_api_001);
        const url_post_001 = `${request_scheme}://${server_name}:${server_port}/${route_api_002}`;
        console.log('URL POST 001: ', url_post_001);

        // Variáveis do react
        const [etapa, setEtapa] = React.useState([]);
        const [loading, setLoading] = React.useState(true);
        const [error, setError] = React.useState(null);
        const [dragIndex, setDragIndex] = React.useState(-1);

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
                    setEtapa(data.result.listar_etapa);
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

        const onDragStart = (e, index) => {
            setDragIndex(index);
        };

        const onDragOver = (e) => {
            e.preventDefault();
        };

        const onDrop = (e, dropIndex) => {
            e.preventDefault();
            setEtapa(prevEtapa => {
                const updatedEtapa = [...prevEtapa];
                const draggedItem = updatedEtapa.splice(dragIndex, 1)[0];
                updatedEtapa.splice(dropIndex, 0, draggedItem);

                // Atualiza a ordem dos itens
                const reorderedEtapa = updatedEtapa.map((item, idx) => ({
                    ...item,
                    order: idx + 1
                }));

                // Chama a função para submeter a nova ordem
                submitNewOrder(reorderedEtapa);

                return reorderedEtapa;
            });
        };

        const submitNewOrder = (updatedEtapa) => {
            const formData = new URLSearchParams();
            updatedEtapa.forEach((etapa, index) => {
                formData.append('setFormOrder[]', `${index + 1}|${etapa.pk_stage}`);
            });

            // Log do formData antes de enviar
            console.log("Dados a serem enviados:", Array.from(formData.entries()));

            fetch(url_post_001, {
                method: 'POST',
                body: formData,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
                .then(response => response.text())
                .then(data => {
                    if (debugMyPrint) {
                        console.log("Submit response:", data);
                    }
                })
                .catch(error => {
                    console.error('Erro ao enviar dados:', error);
                });
        };

        const submitForm = (e) => {
            const formData = new FormData(e.target);
            fetch(url_post_001, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Resposta do servidor:', data);
                    if (debugMyPrint) {
                        console.log(data);
                    }
                })
                .catch(error => {
                    console.error('Erro ao enviar dados:', error);
                });
        };


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
            <div className="mx-5">
                <h2>Lista de Etapas</h2>
                <form onSubmit={(e) => e.preventDefault()}>
                    <table className="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ordem</th>
                                <th>Nº</th>
                                <th>Estragio Atual<br />Estágio</th>
                                <th>Sigla<br />Acrônimo</th>
                                <th>Rótulo<br />Segundo Rotulo</th>
                                <th>Termo interno<br />Padrão interno</th>
                            </tr>
                        </thead>
                        <tbody>
                            {etapa.map((item, index) => (
                                <tr key={index}>
                                    <td>
                                        <i className="bi bi-grip-vertical" draggable="true"
                                            onDragStart={(e) => onDragStart(e, index)}
                                            onDragOver={onDragOver}
                                            onDrop={(e) => onDrop(e, index)}>
                                        </i>
                                    </td>
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
                </form>
                {/* Renderização condicional da seção de revisão e submissão com base no valor de debugMyPrint */}
                {debugMyPrint && (
                    <React.Fragment>
                        <h2>Revisão e Submissão das Etapas</h2>
                        <form method="POST" action={url_post_001}>
                            <table className="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ordem</th>
                                        <th>ID</th>
                                        <th>Estágio</th>
                                        <th>Sigla</th>
                                        <th>Rótulo</th>
                                        <th>Termo Interno</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {etapa.map((item, index) => (
                                        <tr key={index}>
                                            <td>{index + 1}</td>
                                            <td>
                                                <input
                                                    type="text"
                                                    name="setFormOrder[]"
                                                    defaultValue={`${index + 1}|${item.pk_stage}`}
                                                    style={{ width: "100px" }}
                                                />
                                            </td>
                                            <td>{item.pk_stage}</td>
                                            <td>{item.stage}</td>
                                            <td>{item.str_acronym}</td>
                                            <td>{item.str_label}</td>
                                            <td>{item.int_standard_term}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                            <button type="submit" className="btn btn-outline-primary">Enviar</button>
                        </form>
                    </React.Fragment>
                )}
                <div className="container">
                    &nbsp;
                </div>
                {/* Adicionando a visualização dos dados brutos da API quando debugMyPrint está ativo */}
                {debugMyPrint && <pre>{JSON.stringify(etapa, null, 2)}</pre>}
            </div>
        );
    };
    ReactDOM.render(<AllListaEtapa />, document.querySelector('.App_listar_etapa'));
</script>
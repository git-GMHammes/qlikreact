<?php
$parametros_backend = array(
    'url' => base_url() . 'index.php/qlikreact/licitacao/api/listar',
    'post' => base_url() . 'index.php/qlikreact/licitacao/api/ordem',
    'DEBUG_MY_PRINT' => DEBUG_MY_PRINT,
    'getURI' => array(
        "index.php",
        "qlikreact",
        "licitacao",
        "api",
        "listar"
    )
);
?>

<div class="App_listar_licitacao" data-result='<?php echo json_encode($parametros_backend); ?>'></div>

<script type="text/babel">
    const AppListaLicitacao = () => {
        const [processos, setProcessos] = React.useState([]);
        const [carinhas, setCarinhas] = React.useState([]);
        const [loading, setLoading] = React.useState(true);
        const [error, setError] = React.useState(null);
        const [apiRawData, setApiRawData] = React.useState('');
        const [apiRawRespond, setApiRawRespond] = React.useState('');

        const parametros = JSON.parse(document.querySelector('.App_listar_licitacao').getAttribute('data-result'));
        const apiUrl = parametros.url;
        const postUrl = parametros.post;
        const debug = parametros.DEBUG_MY_PRINT;

        React.useEffect(() => {
            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Network response was not ok (${response.status})`);
                    }
                    return response.json();
                })
                .then(data => {
                    setProcessos(data.result.listar_licitacao);
                    setCarinhas(data.result.carinha);
                    setLoading(false);
                })
                .catch(error => {
                    setError(error.toString());
                    setLoading(false);
                });
        }, []);

        const alertStyle = {
            padding: '0.25rem 0.5rem',
            marginBottom: '0',
            height: '30px',
        };

        const visibility_hidden = {
            visibility: 'hidden',
            with: '5px',
        };

        // Função para buscar a carinha correspondente ao pk_bidding e retornar o emoji correspondente
        const getEmojiForBidding = (pk_bidding) => {
            const carinha = carinhas.find(car => car.pk_bidding === pk_bidding);
            if (!carinha) return 'Desconhecido';
            return getEmoji(carinha.emoji);
        };

        // Função que mapeia o tipo de emoji para o componente visual
        const getEmoji = (emojiType) => {
            switch (emojiType) {
                case 'emoji_smile_fill':
                    return <div style={alertStyle} className="alert alert-success me-4" role="alert"><i className="bi bi-emoji-smile-fill"></i></div>;
                case 'emoji_neutral_fill':
                    return <div style={alertStyle} className="alert alert-danger me-4" role="alert"><i className="bi bi-emoji-neutral-fill"></i></div>;
                case 'emoji_frown_fill':
                    return <div style={alertStyle} className="alert alert-warning me-4" role="alert"><i className="bi bi-emoji-frown-fill"></i></div>;
                default:
                    return 'Desconhecido'; // Caso o tipo de emoji não seja reconhecido
            }
        };

        const onDragStart = (e, index) => {
            e.dataTransfer.setData("dragIndex", index);
        };

        const onDragOver = (e) => {
            // Necessário para permitir o drop
            e.preventDefault();
        };

        const onDrop = (e, dropIndex) => {
            e.preventDefault();
            const dragIndex = parseInt(e.dataTransfer.getData("dragIndex"));
            const itemArrastado = processos[dragIndex];
            const itensAtualizados = [...processos];

            itensAtualizados.splice(dragIndex, 1);
            itensAtualizados.splice(dropIndex, 0, itemArrastado);

            setProcessos(itensAtualizados); // Isto irá disparar a atualização de estado
        };

        React.useEffect(() => {
            if (!debug && processos.length > 0) {
                const formData = new URLSearchParams();
                processos.forEach((processo, index) => {
                    formData.append('setFormOrder[]', `${index + 1}|${processo.pk_bidding}`);
                });

                fetch(postUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                    .then(data => {
                        setApiRawRespond(JSON.stringify(data, null, 2));
                    })
                    .catch(error => {
                        console.error('Erro ao enviar dados ou ao processar a resposta:', error);
                    });
            }
        }, [processos]);

        if (loading) {
            return <p>Carregando dados...</p>;
        }

        if (error) {
            return <p>Erro ao carregar dados: {error}</p>;
        }

        return (
            <div className="container">
                <h2>Lista de Processos Licitatórios</h2>
                <div>
                    {/* Teste estático para verificar a renderização do emoji */}
                    <strong>Teste de Emoji para 'qliksensedss_':</strong>
                    {getEmojiForBidding("qliksensedss_")}
                </div>
                {/*
                    console.log("Processos a serem renderizados:", processos)
                */}
                <form id="formProcessos" action={postUrl} method="post">
                    <table className="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <i className="bi bi-hand-index-thumb"></i>
                                </th>
                                <th>
                                    <div className="d-flex justify-content-center">
                                        ID
                                    </div>
                                </th>
                                <th>Chave da Licitação</th>
                                <th>Prazo foi atendido</th>
                                <th>Processo Eletrônico SEI</th>
                            </tr>
                        </thead>
                        <tbody>
                            {processos.map((processo, index) => (
                                <tr key={index}>
                                    <td onDragOver={onDragOver} onDrop={(e) => onDrop(e, index)}>
                                        <i className="bi bi-grip-vertical" draggable="true" onDragStart={(e) => onDragStart(e, index)}></i>
                                    </td>
                                    <td>
                                        <div className="d-flex justify-content-center">
                                            {processo.priority}
                                        </div>
                                        <div className="d-flex justify-content-center">
                                            <input
                                                type={debug ? "text" : "hidden"}
                                                className="form-control"
                                                id={"setFormOrder" + index}
                                                name="setFormOrder[]"
                                                value={index + 1 + "|" + processo.pk_bidding}
                                                readOnly
                                            />
                                        </div>
                                    </td>
                                    <td>{processo.bidding}</td>
                                    <td>
                                        <div className="d-flex justify-content-center">
                                            {processo.not_fulfilled} -
                                            {processo.not_fulfilled === 'N' ? 'Não' : 'Sim'}
                                            &emsp;{getEmojiForBidding(processo.pk_bidding)}
                                        </div>
                                    </td>
                                    <td>{processo.sei}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    {debug ?
                        <React.Fragment>
                            <button type="submit" className="btn btn-primary">Salvar</button>
                            <div className="form-check">
                                <input className="form-check-input" type="radio" name="json" id="json1" value="1" />
                                <label className="form-check-label" htmlFor="json1">JSON - ON</label>
                            </div>
                            <div className="form-check">
                                <input className="form-check-input" type="radio" name="json" id="json2" value="0" defaultChecked />
                                <label className="form-check-label" htmlFor="json2">JSON - OFF</label>
                            </div>
                        </React.Fragment>
                        : null}
                </form>
                {debug ?
                    <React.Fragment>
                        <pre>{apiRawData}</pre>
                        <pre>{setApiRawRespond}</pre>
                    </React.Fragment>
                    : null}
            </div>
        );
    };
    ReactDOM.render(<AppListaLicitacao />, document.querySelector('.App_listar_licitacao'));
</script>
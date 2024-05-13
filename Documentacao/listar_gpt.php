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

        const parametros = JSON.parse(document.querySelector('.App_listar_licitacao').getAttribute('data-result'));
        const apiUrl = parametros.url;

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

        const getEmojiForBidding = (pk_bidding) => {
            const carinha = carinhas.find(car => car.pk_bidding === pk_bidding);
            if (!carinha) return 'Desconhecido';
            return getEmoji(carinha.emoji);
        };

        const getEmoji = (emojiType) => {
            switch (emojiType) {
                case 'emoji_smile_fill':
                    return <i className="bi bi-emoji-smile-fill" style={{color: 'green'}}></i>;
                case 'emoji_neutral_fill':
                    return <i className="bi bi-emoji-neutral-fill" style={{color: 'grey'}}></i>;
                case 'emoji_frown_fill':
                    return <i className="bi bi-emoji-frown-fill" style={{color: 'red'}}></i>;
                default:
                    return 'Desconhecido';
            }
        };

        if (loading) return <p>Carregando dados...</p>;
        if (error) return <p>Erro ao carregar dados: {error}</p>;

        return (
            <div className="container">
                <h2>Lista de Processos Licitatórios</h2>
                <table className="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Chave da Licitação</th>
                            <th>Prazo foi atendido</th>
                            <th>Processo Eletrônico SEI</th>
                            <th>Emoji</th>
                        </tr>
                    </thead>
                    <tbody>
                        {processos.map((processo, index) => (
                            <tr key={index}>
                                <td>{index + 1}</td>
                                <td>{processo.bidding}</td>
                                <td>{processo.not_fulfilled === 'Y' ? 'Sim' : 'Não'}</td>
                                <td>{processo.sei}</td>
                                <td>{getEmojiForBidding(processo.pk_bidding)}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        );
    };

    ReactDOM.render(<AppListaLicitacao />, document.querySelector('.App_listar_licitacao'));
</script>

<script type="text/babel">
    const AppListaLicitacao = () => {
        const [processos, setProcessos] = React.useState([]);
        const [carinhas, setCarinhas] = React.useState([]);
        const [loading, setLoading] = React.useState(true);
        const [error, setError] = React.useState(null);

        const parametros = JSON.parse(document.querySelector('.App_listar_licitacao').getAttribute('data-result'));
        const apiUrl = parametros.url;
        const postUrl = parametros.post;
        
        React.useEffect(() => {
            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Network response was not ok (${response.status})`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.result && data.result.listar_licitacao && data.result.carinha) {
                        setProcessos(data.result.listar_licitacao);
                        setCarinhas(data.result.carinha);
                    } else {
                        throw new Error('Invalid API structure');
                    }
                    setLoading(false);
                })
                .catch(error => {
                    console.error('Error fetching data: ', error);
                    setError(error.toString());
                    setLoading(false);
                });
        }, []);

        const onDragStart = (e, index) => {
            e.dataTransfer.setData("dragIndex", index);
        };

        const onDragOver = (e) => {
            e.preventDefault(); // Necessário para permitir o drop
        };

        const onDrop = (e, dropIndex) => {
            e.preventDefault();
            const dragIndex = parseInt(e.dataTransfer.getData("dragIndex"));
            const itemArrastado = processos[dragIndex];
            const itensAtualizados = [...processos];
            itensAtualizados.splice(dragIndex, 1); // Remove o item da posição original
            itensAtualizados.splice(dropIndex, 0, itemArrastado); // Insere o item na nova posição
            setProcessos(itensAtualizados);
        };

        if (loading) {
            return <p>Carregando dados...</p>;
        }

        if (error) {
            return <p>Erro ao carregar dados: {error}</p>;
        }

        return (
            <div className="container">
                <h2>Lista de Processos Licitatórios</h2>
                <form action={postUrl} method="post">
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
                                <th>
                                    <div className="d-flex justify-content-center">
                                        Ind
                                    </div>
                                </th>
                                <th>Chave da Licitação</th>
                                <th>Prazo não cumprido</th>
                                <th>Processo Eletrônico SEI</th>
                            </tr>
                        </thead>
                        <tbody>
                            {processos.map((processo, index) => (
                                <tr key={index} draggable onDragOver={onDragOver} onDrop={(e) => onDrop(e, index)}>
                                    <td draggable="true" onDragStart={(e) => onDragStart(e, index)}>
                                        <i className="bi bi-grip-vertical"></i>
                                    </td>
                                    <td>
                                        <div className="d-flex justify-content-center">
                                            {processo.priority}
                                        </div>
                                    </td>
                                    <td>
                                        <div className="d-flex justify-content-center">
                                            <input type="text" className="form-control" id="setFormOrder" name="setFormOrder" value={index + 1} readOnly />
                                        </div>
                                    </td>
                                    <td>{processo.bidding}</td>
                                    <td>
                                        <div className="d-flex justify-content-center">
                                            {processo.not_fulfilled === 'N' ? 'Não' : 'Sim'} &emsp;
                                            {getEmojiForBidding(processo.pk_bidding)}
                                        </div>
                                    </td>
                                    <td>{processo.sei}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </form>
            </div>
        );
    };

    ReactDOM.render(<AppListaLicitacao />, document.querySelector('.App_listar_licitacao'));
</script>

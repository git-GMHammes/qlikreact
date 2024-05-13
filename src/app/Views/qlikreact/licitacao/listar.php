<?php
$parametros_backend = array(
    'url' => base_url() . 'index.php/qlikreact/licitacao/api/listar',
    'post' => base_url() . 'index.php/qlikreact/licitacao/api/ordem',
    'DEBUG_MY_PRINT' => false,
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
        const [dragIndex, setDragIndex] = React.useState(-1);

        const parametros = JSON.parse(document.querySelector('.App_listar_licitacao').getAttribute('data-result'));
        const apiUrl = parametros.url;
        const postUrl = parametros.post;
        const debug = parametros.DEBUG_MY_PRINT;

        // Este useEffect é executado uma única vez após o componente ser montado, devido ao array de dependências vazio ([]).
        React.useEffect(() => {
            // A função fetch é usada para realizar uma requisição GET ao servidor no endpoint especificado em apiUrl.
            fetch(apiUrl)
                .then(response => {
                    // Primeiro, verifica se a resposta do servidor foi bem-sucedida.
                    if (!response.ok) {
                        // Se a resposta não foi bem-sucedida, lança um erro com a mensagem incluindo o status da resposta.
                        throw new Error(`Network response was not ok (${response.status})`);
                    }
                    // Se a resposta foi bem-sucedida, converte os dados recebidos de JSON para um objeto JavaScript.
                    return response.json();
                })
                .then(data => {
                    // Após a conversão dos dados para objeto JavaScript, atualiza o estado `processos` com os dados específicos de licitações recebidos.
                    setProcessos(data.result.listar_licitacao);
                    // Atualiza o estado `carinhas` com os dados de carinhas recebidos.
                    setCarinhas(data.result.carinha);
                    // Define o estado de carregamento como false, indicando que os dados foram carregados com sucesso.
                    setLoading(false);
                })
                .catch(error => {
                    // Se ocorrer algum erro durante a requisição ou processamento dos dados, atualiza o estado de erro com a mensagem do erro.
                    setError(error.toString());
                    // Define o estado de carregamento como false, indicando que a tentativa de carregar dados terminou, mesmo que com erro.
                    setLoading(false);
                });
        }, []);
        // Esta função é responsável por encontrar a "carinha" (emoji) correspondente a uma licitação específica.
        const getEmojiForBidding = (pk_bidding) => {
            // Utiliza o método 'find' no array 'carinhas' para encontrar o primeiro elemento cujo 'pk_bidding' corresponde ao fornecido.
            const carinha = carinhas.find(car => car.pk_bidding === pk_bidding);
            // Verifica se uma carinha foi encontrada.
            if (!carinha) {
                // Se não encontrar uma correspondência, retorna a string 'Desconhecido'.
                return 'Desconhecido';
            }
            // Se uma carinha foi encontrada, chama a função 'getEmoji', passando o tipo de emoji da carinha encontrada.
            return getEmoji(carinha.emoji);
        };
        // Função para mapear o tipo de emoji recebido para um componente visual específico.
        const getEmoji = (emojiType) => {
            switch (emojiType) {
                case 'emoji_smile_fill':
                    return <i className="bi bi-emoji-smile-fill" style={{ color: 'green' }}></i>;
                case 'emoji_neutral_fill':
                    return <i className="bi bi-emoji-neutral-fill" style={{ color: 'grey' }}></i>;
                case 'emoji_frown_fill':
                    return <i className="bi bi-emoji-frown-fill" style={{ color: 'red' }}></i>;
                default:
                    return 'Desconhecido';
            }
        };
        // Função chamada quando o arrastar é iniciado; armazena o índice do item arrastado.
        const onDragStart = (e, index) => {
            setDragIndex(index);
        };
        // Função chamada quando um item está sendo arrastado sobre um possível local de soltura; previne o comportamento padrão.
        const onDragOver = (e) => {
            e.preventDefault();
        };
        // Função chamada quando um item é solto sobre um novo local; reordena a lista de processos.
        const onDrop = (e, dropIndex) => {
            e.preventDefault();  // Previne o comportamento padrão para permitir a soltura.
            const updatedProcessos = [...processos];  // Cria uma cópia do array de processos.
            const draggedItem = updatedProcessos.splice(dragIndex, 1)[0];  // Remove o item arrastado do seu local original.
            updatedProcessos.splice(dropIndex, 0, draggedItem);  // Insere o item arrastado no novo índice.
            setProcessos(updatedProcessos);  // Atualiza o estado com a nova ordem dos processos.
            submitNewOrder(updatedProcessos);  // Envia a nova ordem dos processos para processamento ou salvamento.
        };
        // Função para submeter a nova ordem dos processos após reordená-los.
        const submitNewOrder = (updatedProcessos) => {
            // Inicia a construção de um objeto FormData para enviar os dados via POST.
            const formData = new URLSearchParams();
            // Itera sobre os processos atualizados, adicionando cada um ao objeto formData.
            updatedProcessos.forEach((processo, index) => {
                // Adiciona a nova ordem e o identificador do processo ao formData.
                formData.append('setFormOrder[]', `${index + 1}|${processo.pk_bidding}`);
            });

            // Realiza uma requisição POST para o servidor com os dados atualizados.
            fetch(postUrl, {
                method: 'POST', // Método HTTP.
                body: formData, // Corpo da requisição, contendo os dados dos processos.
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' } // Cabeçalho informando o tipo de conteúdo.
            }).then(response => response.text()) // Converte a resposta para texto.
                .then(data => {
                    // Se o modo de depuração estiver ativo, loga a resposta do servidor no console.
                    if (debug) {
                        console.log("Submit response:", data);
                    }
                })
                .catch(error => {
                    // Loga erros de rede ou de requisição no console.
                    console.error('Erro ao enviar dados:', error);
                });
        };

        if (loading) return <p>Carregando dados...</p>;
        if (error) return <p>Erro ao carregar dados: {error}</p>;

        return (
            <div className="container">
                <h2>Lista de Processos Licitatórios</h2>
                {/*Cria um formulário que intercepta o evento de submit padrão para prevenir o comportamento de recarregar a página.*/}
                <form onSubmit={(e) => e.preventDefault()}>
                    {/*
                        // Esta linha previne o comportamento padrão do formulário, que é enviar e recarregar a página.
                        // Ao chamar e.preventDefault(), o envio do formulário não causará o recarregamento da página,
                        // permitindo que a interação aconteça sem interrupções e mantendo o estado do aplicativo.
                    */}
                    <table className="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>#</th>
                                <th>Chave da Licitação</th>
                                <th>No Prazo</th>
                                <th>Emoji</th>
                                <th>Processo Eletrônico SEI</th>
                            </tr>
                        </thead>
                        <tbody>
                            {processos.map((processo, index) => (
                                <tr key={index}>
                                    <td>
                                        <i className="bi bi-grip-vertical" draggable="true"
                                            {/*// Atributo onDragStart associado ao ícone, iniciado quando um drag (arraste) começa.*/}
                                            onDragStart={(e) => onDragStart(e, index)}
                                            {/* Atributo onDragOver que é chamado sempre que um item arrastado passa sobre um possível local de soltura.*/}
                                            onDragOver={onDragOver}
                                            {/* Atributo onDrop que é chamado quando um item é solto sobre o elemento. Este evento finaliza o processo de arrastar e soltar.*/}
                                            {/**/}
                                            onDrop={(e) => onDrop(e, index)}></i>
                                    </td>
                                    <td>{index + 1}</td>
                                    <td>{processo.bidding}</td>
                                    <td>{processo.not_fulfilled === 'Y' ? 'Sim' : 'Não'}</td>
                                    <td>{getEmojiForBidding(processo.pk_bidding)}</td>
                                    <td>{processo.sei}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    {debug && <pre>{JSON.stringify(processos, null, 2)}</pre>}
                </form>
            </div>
        );
    };

    ReactDOM.render(<AppListaLicitacao />, document.querySelector('.App_listar_licitacao'));
</script>
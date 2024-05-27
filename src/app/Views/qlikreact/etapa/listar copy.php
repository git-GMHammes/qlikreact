<script type="text/babel">
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
        {debugMyPrint && <pre>{JSON.stringify(etapa, null, 2)}</pre>}
    </form>
</div>
</script>
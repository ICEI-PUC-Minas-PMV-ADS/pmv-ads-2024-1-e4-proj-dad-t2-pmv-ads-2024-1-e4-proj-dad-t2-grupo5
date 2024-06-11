<div class="modal fade" id="registrarExameModal" tabindex="-1" role="dialog" aria-labelledby="registrarExameModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrarExameModalLabel">Gestão de Exame</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary btn-block" onclick="imprimirSolicitacao()">Imprimir Solicitação</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success btn-block" onclick="registrarExameRealizado()">Registrar Exame</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalRegistrarExame" tabindex="-1" role="dialog" aria-labelledby="modalRegistrarExameLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarExameLabel">Registrar Exame Realizado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarExame">
                    <div class="form-group">
                        <label>Data de Realização</label>
                        <input type="date" class="form-control" name="dataRealizacao" required>
                    </div>
                    <div class="form-group">
                        <label>Observações</label>
                        <input type="text" class="form-control" name="observacoes">
                    </div>
                    <div id="resultadosExame">
                        <h5>Resultados</h5>
                        <div class="form-row resultado-exame">
                            <div class="col">
                                <input type="text" class="form-control" name="nomeExame[]" placeholder="Nome do Exame" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="resultado[]" placeholder="Resultado" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="normalRange[]" placeholder="Faixa Normal" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="adicionarResultado()">+</button>
                    <button type="submit" class="btn btn-primary mt-2">Registrar Exame</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function imprimirSolicitacao() {
        var atendimentoId = $('#registrarExameModal').data('atendimentoId');
        console.log('Imprimindo solicitação...');
    }

    function registrarExameRealizado() {
        var atendimentoId = $('#registrarExameModal').data('atendimentoId');
        var pacienteId = $('#registrarExameModal').data('pacienteId');
        var medicoId = $('#registrarExameModal').data('medicoId');

        var form = $('#formRegistrarExame');
        form.data('atendimentoId', atendimentoId);
        form.data('pacienteId', pacienteId);
        form.data('medicoId', medicoId);

        $('#modalRegistrarExame').modal('show');
    }
</script>


<script>
function adicionarResultado() {
    const container = document.getElementById('resultadosExame');
    const novoResultado = document.createElement('div');
    novoResultado.className = 'form-row resultado-exame';
    novoResultado.innerHTML = `
        <div class="col">
            <input type="text" class="form-control" name="nomeExame[]" placeholder="Nome do Exame" required>
        </div>
        <div class="col">
            <input type="text" class="form-control" name="resultado[]" placeholder="Resultado" required>
        </div>
        <div class="col">
            <input type="text" class="form-control" name="normalRange[]" placeholder="Faixa Normal" required>
        </div>
    `;
    container.appendChild(novoResultado);
}

// Função para enviar dados
document.getElementById('formRegistrarExame').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = $(this);
    const atendimentoId = form.data('atendimentoId');
    const pacienteId = form.data('pacienteId');
    const medicoId = form.data('medicoId');

    const formData = new FormData(this);
    const data = {
        solicitacaoRef: {
            AtendimentoId: atendimentoId,
            medico: medicoId,
            paciente: pacienteId
        },
        resultados: [],
        dataRealizacao: formData.get('dataRealizacao'),
        observacoes: formData.get('observacoes')
    };

    formData.getAll('nomeExame[]').forEach((nomeExame, index) => {
        data.resultados.push({
            nomeExame: nomeExame,
            resultado: formData.getAll('resultado[]')[index],
            normalRange: formData.getAll('normalRange[]')[index]
        });
    });

    console.log('URL sendo chamada:', 'http://localhost:3001/examesRealizados/');
    console.log('Dados sendo enviados:', JSON.stringify(data));

    fetch('http://localhost:3001/examesRealizados/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        alert('Exame registrado com sucesso!');
        $('#modalRegistrarExame').modal('hide');
    })
    .catch(error => {
        console.error('Erro ao registrar exame:', error);
        alert('Erro ao registrar exame: ' + error.message);
    });
});
</script>



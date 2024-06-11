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
                        <button type="button" class="btn btn-success btn-block" id="btnAcaoExame" onclick="registrarExameRealizado()">Registrar Exame</button>
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
    function verificarExame(atendimentoId) {
        $.ajax({
            url: `http://localhost:3001/examesRealizados/${atendimentoId}`,
            type: 'GET',
            headers: {
                'x-api-key': '<?php echo addslashes($apiKey); ?>'
            },
            success: function(response) {
                if (response.exists) {
                    $('#btnAcaoExame').text('Imprimir Exame').attr('onclick', 'imprimirExameRealizado()');
                } else {
                    $('#btnAcaoExame').text('Registrar Exame').attr('onclick', 'registrarExameRealizado()');
                }
                $('#registrarExameModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao verificar a existência da realização de exame: ' + error);
                alert('Erro ao verificar a existência de exame.');
            }
        });
    }

    function imprimirSolicitacao() {
        var atendimentoId = $('#registrarExameModal').data('atendimentoId');
        console.log( atendimentoId);
        
        $.ajax({
            url: `http://localhost:3001/solicitacaoExames/atendimento/${atendimentoId}`,
            type: 'GET',
            success: function(data) {
                var conteudoParaImprimir = montarConteudoImpressao(data);
                var janelaDeImpressao = window.open('', '_blank', 'width=800,height=600');
                janelaDeImpressao.document.open();
                janelaDeImpressao.document.write(conteudoParaImprimir);
                janelaDeImpressao.document.close();
                janelaDeImpressao.focus();
                janelaDeImpressao.print();
                janelaDeImpressao.close();
            },
            error: function(xhr, status, error) {
                console.error('Erro ao obter dados para impressão:', error);
            }
        });
    }

    function montarConteudoImpressao(dados) {
        var html = `
            <html>
            <head>
                <title>Solicitação de Exame</title>
                <style>
                    body { font-family: Arial, sans-serif; font-size: 14px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                <h1>Solicitação de Exame</h1>
                <p>Atendimento ID: ${dados.atendimentoRef.AtendimentoId}</p>
                <p>Médico ID: ${dados.atendimentoRef.medicoId}</p>
                <p>Paciente ID: ${dados.atendimentoRef.pacienteId}</p>
                <table>
                    <tr><th>Exame</th><th>Solicitado</th></tr>
        `;

        Object.keys(dados).forEach(key => {
            if (typeof dados[key] === 'boolean') {
                html += `<tr><td>${key}</td><td>${dados[key] ? 'Sim' : 'Não'}</td></tr>`;
            }
        });

        html += `
                </table>
            </body>
            </html>
        `;
        return html;
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

    function abrirGestaoExame(atendimentoId) {
        $('#registrarExameModal').data('atendimentoId', atendimentoId);
        verificarExame(atendimentoId);
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

    fetch('http://localhost:3001/examesRealizados/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        $('#modalRegistrarExame').modal('hide');
        location.reload();
    })
    .catch(error => {
        console.error('Erro ao registrar exame:', error);
        alert('Erro ao registrar exame: ' + error.message);
    });
});
</script>



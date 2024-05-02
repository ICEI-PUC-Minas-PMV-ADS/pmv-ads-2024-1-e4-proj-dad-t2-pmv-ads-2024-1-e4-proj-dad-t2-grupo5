<div class="modal fade" id="criarReceitaModal" tabindex="-1" role="dialog" aria-labelledby="criarReceitaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="criarReceitaModalLabel">Criar Receita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formReceita">
                    <input type="hidden" id="atendimentoRef" name="atendimentoRef[AtendimentoId]">
                    <input type="hidden" id="medicoId" name="atendimentoRef[medicoId]">
                    <input type="hidden" id="pacienteId" name="atendimentoRef[paciente]">

                    <input type="hidden" id="atendimentoRef" name="atendimentoRef[AtendimentoId]">
                    <input type="hidden" id="medicoId" name="atendimentoRef[medicoId]">
                    <input type="hidden" id="pacienteId" name="atendimentoRef[paciente]">

                    <label for="dataFim">Data de Fim:</label>
                    <input type="date" id="dataFim" name="dataFim" required><br>

                    <label for="observacoes">Observações:</label>
                    <textarea id="observacoes" name="observacoes"></textarea><br>

                    <div id="medicamentos">
                        <!-- Campos de medicamentos serão adicionados aqui -->
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="adicionarMedicamento()">Adicionar Medicamento</button><br><br>

                    <button type="submit" class="btn btn-primary">Salvar Receita</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        adicionarMedicamento();
    });

    function adicionarMedicamento() {
        const container = document.getElementById('medicamentos');
        const index = container.children.length;

        const html = `
            <div class="medicamento-group">
                <label for="medicamento_${index}_nome">Nome do Medicamento:</label>
                <input type="text" id="medicamento_${index}_nome" name="medicamentos[${index}][nome]" required>

                <label for="medicamento_${index}_quantidade">Quantidade:</label>
                <input type="number" id="medicamento_${index}_quantidade" name="medicamentos[${index}][quantidade]" required>

                <label for="medicamento_${index}_periodo">Período:</label>
                <input type="text" id="medicamento_${index}_periodo" name="medicamentos[${index}][periodo]" required>
                <button type="button" class="btn btn-danger" onclick="removerMedicamento(this)">Remover</button>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
    }

    function removerMedicamento(button) {
        const medicamentoGroup = button.closest('.medicamento-group');
        medicamentoGroup.remove();
    }

    function emitirReceita(atendimentoId) {
        $.ajax({
            url: `http://localhost:3001/atendimentos/${atendimentoId}`,
            type: 'GET',
            headers: {
                'x-api-key': '<?php echo $apiKey; ?>'
            },
            success: function(data) {
                if (data.length > 0) {
                    var atendimento = data[0]; 

                    console.log("Dados do atendimento:", atendimento);

                    $('#atendimentoRef').val(atendimento._id);
                    $('#medicoId').val(atendimento.medico._id);
                    $('#pacienteId').val(atendimento.paciente._id);

                    $('#criarReceitaModal').modal('show');
                } else {
                    console.error("Nenhum atendimento encontrado.");
                }
            },
            error: function(xhr, status, error) {
                console.log('Erro ao carregar dados do atendimento: ' + error);
            }
        });
    }



    $('#formReceita').on('submit', function(e) {
    e.preventDefault();

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    var formDataJson = {
        atendimentoRef: {
            AtendimentoId: $('#atendimentoRef').val(),
            medicoId: $('#medicoId').val(),
            paciente: $('#pacienteId').val()
        },
        dataFim: formatDate($('#dataFim').val()),
        observacoes: $('#observacoes').val(),
        medicamentos: []
    };

    $('.medicamento-group').each(function(index, elem) {
        formDataJson.medicamentos.push({
            nome: $(elem).find('[name*="[nome]"]').val(),
            quantidade: $(elem).find('[name*="[quantidade]"]').val(),
            periodo: $(elem).find('[name*="[periodo]"]').val(),
        });
    });

    $.ajax({
        url: 'http://localhost:3001/receita',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formDataJson),
        headers: {
            'x-api-key': '<?php echo $apiKey; ?>'
        },
        success: function(response) {
            console.log('Receita criada com sucesso!');
            $('#criarReceitaModal').modal('hide');
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function(xhr, status, error) {
            console.log('Erro ao criar receita: ' + error);
            console.log('Resposta do erro:', xhr.responseText);
        }
        });
    });
</script>
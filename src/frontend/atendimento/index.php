<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$apiKey = $_ENV['API_KEY'];

include '../partials/header.php';

$usuarioId = isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila de Pacientes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $domain; ?>/style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
</head>
<body>
    

<main class="container mt-4">
    <h2>Minha fila de Pacientes</h2>
    <table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Idade</th>
            <th>Tipo de Atendimento</th>
            <th>Data e Hora</th>
            <th>Nome do Profissional</th>
            <th>Ações</th>
        </tr>         
    </thead>
    <tbody id="tabelaFila">
    </tbody>
</table>
</main>

<!-- Modal de Atendimento -->
<div class="modal fade" id="modalAtendimento" tabindex="-1" role="dialog" aria-labelledby="modalAtendimentoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAtendimentoLabel">Adicionar Atendimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAtendimento">
                    <input type="hidden" id="pacienteSus" value="">
                    <div class="form-group">
                        <label for="descricaoSubjetivo">Subjetivo</label>
                        <textarea class="form-control" id="descricaoSubjetivo" name="descricaoSubjetivo" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="descricaoObjetivo">Objetivo</label>
                        <textarea class="form-control" id="descricaoObjetivo" name="descricaoObjetivo" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="descricaoAvaliacao">Avaliação</label>
                        <textarea class="form-control" id="descricaoAvaliacao" name="descricaoAvaliacao" required placeholder="Detalhes gerais da avaliação."></textarea>
                        <div class="mt-3">
                            <label for="pressao">Pressão</label>
                            <input type="text" class="form-control" id="pressao" name="pressao" required>
                            <label for="glicemia">Glicemia</label>
                            <input type="text" class="form-control" id="glicemia" name="glicemia" required>
                            <label for="peso">Peso</label>
                            <input type="text" class="form-control" id="peso" name="peso" required>
                            <label for="altura">Altura</label>
                            <input type="text" class="form-control" id="altura" name="altura" required>
                            <div class="form-group">
                                 <label for="codigoInput">Código CID:</label>
                                <input type="text" class="form-control" id="codigoInput" />
                            </div>
                            <div class="form-group">
                                <label for="nomeSelect">Nome CID:</label>
                                <select class="form-control" id="nomeSelect">
                                <option value="">Selecione uma doença CID</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="codigoInput">Código CIAP:</label>
                                <input type="text" class="form-control" id="codigoInput" />
                            </div>
                            <div class="form-group">
                                <label for="nomeSelect">Nome CIAP:</label>
                                <select class="form-control" id="nomeSelect">
                                <option value="">Selecione uma doença CIAP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descricaoPlanoTerapeutico">Plano Terapêutico</label>
                        <textarea class="form-control" id="descricaoPlanoTerapeutico" name="descricaoPlanoTerapeutico" required></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exameSolicitado">
                        <label class="form-check-label" for="exameSolicitado">Solicitar Exame?</label>
                    </div>
                    <input type="hidden" id="medicoId" value="<?php echo $usuarioId; ?>">
                    <input type="hidden" id="pacienteId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="enviarAtendimento">Enviar</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>


<script>
    var usuarioId = <?php echo json_encode($usuarioId); ?>;

        $(document).on('click', '.cancelarBtn', function() {
            var filaId = $(this).data('fila-id'); 
            var pacienteId = $(this).data('paciente-id');
            var pacientesus = $(this).data('paciente-sus');

            console.log('sus', pacientesus)

            $('#filaId').val(filaId); 
            $('#pacienteId').val(pacienteId);
            $('#pacienteSus').val(pacientesus);

            $('#modalAtendimento').modal('show');
        });

$('#enviarAtendimento').click(function() {
    var descricao = $('#descricao').val();
    var exameSolicitado = $('#exameSolicitado').is(':checked');
    var medicoId = $('#medicoId').val();
    var pacienteId = $('#pacienteId').val();
    var pacientesus = $('#pacienteSus').val();

    var dadosAtendimento = {
        descricao: descricao,
        exameSolicitado: exameSolicitado,
        medico: medicoId,
        paciente: pacienteId
    };

    $.ajax({
        url: 'https://vivabemapi.vercel.app/atendimentos',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(dadosAtendimento),
        success: function(response) {
            atualizarStatusFila(pacienteId, true, pacientesus);
        },
        error: function() {
            alert('Erro ao adicionar atendimento');
        }
    });
});

function atualizarStatusFila(filaId, atendido, pacientesus) {
    $.ajax({
        url: `https://vivabemapi.vercel.app/fila/atualizar/${filaId}`,
        method: 'PUT',
        contentType: 'application/json',
        success: function(response) {
            $('#modalAtendimento').modal('hide');
            alert('Atendimento adicionado e fila atualizada com sucesso!');
            window.location.href = '<?php echo $domain; ?>/pacientes/atendimentos.php?pacienteId=' + pacientesus; // Usar pacientesus aqui
            carregarFila();
        },
        error: function() {
            alert('Erro ao atualizar status na fila');
        }
    });
}



$(document).ready(function() {
    carregarFila();
    $('#adicionarBtn').on('click', function() {
        $('#modalAdicionarFila').modal('show');
        $('#searchPaciente').val('');
        $('#pacienteOptions').empty();
        $('#btnAdicionarPaciente').prop('disabled', true);
        carregarProfissionais();
    });

    $(document).on('input', '#searchPaciente', function() {
        var searchTerm = $(this).val();
        if (searchTerm && searchTerm.length >= 3) {
            carregarPacientes(searchTerm);
        } else {
            $('#pacienteOptions').empty();
        }
    });

    $(document).on('change input', '#searchPaciente, #tipoAtendimento, #selecaoProfissional', function() {
        checkForm();
    });
});

function carregarFila() {
    $.ajax({
        url: 'https://vivabemapi.vercel.app/fila/profissional/' + usuarioId,
        method: 'GET',
        success: function(response) {
            $('#tabelaFila').empty();
            response.forEach(function(item) {
                var nomePaciente = item.paciente && item.paciente.nome ? item.paciente.nome : 'Desconhecido';
                var idadePaciente = item.paciente && item.paciente.idade ? item.paciente.idade : '-';
                var nomeProfissional = item.profissional && item.profissional.nome ? item.profissional.nome : 'Desconhecido';
                var newRow = $('<tr>');
                newRow.append('<td>' + nomePaciente + '</td>');
                newRow.append('<td>' + idadePaciente + '</td>');
                newRow.append('<td>' + item.tipoAtendimento + '</td>');
                var dataHora = new Date(item.dataHoraRecepcao);
                newRow.append('<td>' + dataHora.toLocaleDateString('pt-BR') + ' ' + dataHora.toLocaleTimeString('pt-BR') + '</td>');
                newRow.append('<td>' + nomeProfissional + '</td>');
                newRow.append('<td>' +
                    '<button type="button" class="btn btn-success cancelarBtn" data-paciente-sus="' + item.paciente.sus + '" data-fila-id="' + item._id + '" data-paciente-id="' + item.paciente._id + '">Chamar</button>' +
                '</td>');
                $('#tabelaFila').append(newRow);
            });
        },
        error: function(xhr) {
            console.error('Erro ao carregar a fila de pacientes:', xhr.responseText);
        }
    });
}

fetch("../data/cids.js")
        .then((response) => response.json())
        .then((data) => {
          // Popula o select com os nomes das doenças CID
          const selectElement = document.getElementById("nomeSelect");
          data.forEach((cid) => {
            const option = document.createElement("option");
            option.text = cid.nome;
            option.value = cid.codigo;
            selectElement.appendChild(option);
          });

          // Event listener para atualizar o código CID quando uma doença CID é selecionada
          selectElement.addEventListener("change", function () {
            const codigoInput = document.getElementById("codigoInput");
            const selectedOption =
              selectElement.options[selectElement.selectedIndex];
            codigoInput.value = selectedOption.value;
          });

          // Event listener para atualizar a doença CID quando um código CID é digitado
          const codigoInput = document.getElementById("codigoInput");
          codigoInput.addEventListener("input", function () {
            const codigo = codigoInput.value;
            const selectedOption = Array.from(selectElement.options).find(
              (option) => option.value === codigo
            );
            if (selectedOption) {
              selectElement.value = selectedOption.value;
            }
          });
        });

    fetch("../data/ciap.js")
        .then((response) => response.json())
        .then((data) => {
          // Popula o select com os nomes das doenças CID
          const selectElement = document.getElementById("nomeSelect");
          data.forEach((cid) => {
            const option = document.createElement("option");
            option.text = cid.nome;
            option.value = cid.codigo;
            selectElement.appendChild(option);
          });

          // Event listener para atualizar o código CID quando uma doença CID é selecionada
          selectElement.addEventListener("change", function () {
            const codigoInput = document.getElementById("codigoInput");
            const selectedOption =
              selectElement.options[selectElement.selectedIndex];
            codigoInput.value = selectedOption.value;
          });

          // Event listener para atualizar a doença CID quando um código CID é digitado
          const codigoInput = document.getElementById("codigoInput");
          codigoInput.addEventListener("input", function () {
            const codigo = codigoInput.value;
            const selectedOption = Array.from(selectElement.options).find(
              (option) => option.value === codigo
            );
            if (selectedOption) {
              selectElement.value = selectedOption.value;
            }
          });
        });

</script>

<?php
include '../partials/footer.php';
?>
</body>
</html>

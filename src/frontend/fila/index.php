<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$apiKey = $_ENV['API_KEY'];

include '../partials/header.php';


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost:3001/fila");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "x-api-key: $apiKey"
));

$resposta = curl_exec($ch);

curl_close($ch);

$estoque = json_decode($resposta, true);

if (!$estoque || curl_errno($ch)) {
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila de Pacientes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $domain; ?>/style.css">
</head>
<body>
    <main class="container mt-4">
        <h2>Fila de Pacientes</h2>
        <button type="button" class="btn btn-primary mb-2" id="adicionarBtn">Adicionar à Fila</button>
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

    <!-- Modal de Adicionar à Fila -->
    <div class="modal fade" id="modalAdicionarFila" tabindex="-1" role="dialog" aria-labelledby="modalAdicionarFilaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalAdicionarFilaLabel">Adicionar Paciente à Fila</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Modal Adicionar a Fila -->
        <div class="modal-body">
            <input type="text" class="form-control mb-2" id="searchPaciente" placeholder="Digite o nome do paciente" list="pacienteOptions">
            <datalist id="pacienteOptions"></datalist>
            <select class="form-control mb-2" id="tipoAtendimento">
                <option value="">Selecione o tipo de atendimento</option>
                <option value="Eletivo">Eletivo</option>
                <option value="Prioritário">Prioritário</option>
                <option value="Emergencial">Emergencial</option>
            </select>
            <select class="form-control" id="selecaoProfissional">
                <option value="">Selecione um profissional</option>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" id="btnAdicionarPaciente" disabled>Adicionar</button>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal Adicionar Paciente -->
    <div class="modal fade" id="adicionarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="adicionarPacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adicionarPacienteModalLabel">Adicionar Novo Paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="adicionarPacienteForm">
                        <!-- Campos do formulário, ex: Nome, Data de Nascimento, etc. -->
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <!-- Adicione mais campos conforme necessário -->
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
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

            $(document).on('click', '.cancelarBtn', function() {
                var itemId = $(this).data('id');
                excluirItemFila(itemId);
            });

            $('#btnAdicionarPaciente').on('click', function() {
                adicionarPacienteAFila();
            });
        });

        function carregarFila() {
            $.ajax({
                url: 'http://localhost:3001/fila',
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
                            '<button type="button" class="btn btn-danger cancelarBtn" data-id="' + item._id + '">Tirar da Fila</button>' +
                        '</td>');
                        $('#tabelaFila').append(newRow);
                    });
                },
                error: function(xhr) {
                    console.error('Erro ao carregar a fila de pacientes:', xhr.responseText);
                }
            });
        }

        function carregarPacientes(searchTerm) {
            $.ajax({
                url: `http://localhost:3001/pacientes?nome=${encodeURIComponent(searchTerm)}`,
                method: 'GET',
                success: function(pacientes) {
                    $('#pacienteOptions').empty();
                    pacientes.forEach(function(paciente) {
                        if (typeof paciente.nome === 'string' && paciente.nome.toLowerCase().includes(searchTerm.toLowerCase())) {
                            var option = $('<option>').val(paciente.nome).attr('data-id', paciente._id).attr('data-idade', paciente.idade);
                            $('#pacienteOptions').append(option);
                        }
                    });
                },
                error: function() {
                    console.error('Erro ao carregar pacientes');
                }
            });
        }

        function carregarProfissionais() {
            $.ajax({
                url: 'http://localhost:3001/usuarios',
                method: 'GET',
                success: function(profissionais) {
                    var selecao = $('#selecaoProfissional');
                    selecao.empty().append('<option value="">Selecione um profissional</option>');
                    profissionais.forEach(function(profissional) {
                        selecao.append($('<option>').val(profissional._id).text(profissional.nome));
                    });
                },
                error: function() {
                    console.error('Erro ao carregar profissionais');
                }
            });
        }

        function checkForm() {
            var isPacienteSelected = $('#searchPaciente').val() !== '';
            var isTipoSelected = $('#tipoAtendimento').val() !== '';
            var isProfissionalSelected = $('#selecaoProfissional').val() !== '';

            $('#btnAdicionarPaciente').prop('disabled', !isPacienteSelected || !isTipoSelected || !isProfissionalSelected);
        }

        function adicionarPacienteAFila() {
            var pacienteNome = $('#searchPaciente').val();
            var pacienteId = $('#pacienteOptions').find('option[value="' + pacienteNome + '"]').attr('data-id');
            var tipoAtendimento = $('#tipoAtendimento').val();
            var profissionalId = $('#selecaoProfissional').val();
            var dataHoraRecepcao = new Date().toISOString(); // Ajuste conforme a necessidade de envio de data/hora

            if (pacienteId && tipoAtendimento && profissionalId) {
                $.ajax({
                    url: 'http://localhost:3001/fila/adicionar',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        paciente: pacienteId,
                        tipoAtendimento: tipoAtendimento,
                        profissional: profissionalId,
                        dataHoraRecepcao: dataHoraRecepcao
                    }),
                    success: function(response) {
                        console.log('Paciente adicionado com sucesso:', response);
                        $('#modalAdicionarFila').modal('hide');
                        carregarFila();  // Recarrega a fila para mostrar o paciente recém-adicionado
                    },
                    error: function(xhr) {
                        console.error('Erro ao adicionar paciente à fila:', xhr.responseText);
                    }
                });
            } else {
                alert('Todos os campos devem ser preenchidos corretamente.');
            }
        }

        function excluirItemFila(itemId) {
            $.ajax({
                url: 'http://localhost:3001/fila/' + itemId,
                type: 'DELETE',
                success: function(result) {
                    console.log('Item removido com sucesso:', result);
                    carregarFila(); // Recarrega a lista para refletir a mudança
                },
                error: function(xhr) {
                    console.error('Erro ao excluir o item da fila:', xhr.responseText);
                }
            });
        }
    </script>

    <?php
        include '../partials/footer.php';
    ?>

</body>
</html>

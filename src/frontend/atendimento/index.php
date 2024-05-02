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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    var usuarioId = <?php echo json_encode($usuarioId); ?>;

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
        url: 'http://localhost:3001/fila/profissional/' + usuarioId,
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
                    '<button type="button" class="btn btn-success cancelarBtn" data-id="' + item._id + '">Chamar</button>' +
                '</td>');
                $('#tabelaFila').append(newRow);
            });
        },
        error: function(xhr) {
            console.error('Erro ao carregar a fila de pacientes:', xhr.responseText);
        }
    });
}


</script>

<?php
include '../partials/footer.php';
?>
</body>
</html>

<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$apiKey = $_ENV['API_KEY'];

include '../partials/header.php';



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost:3001/list");
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
    <link rel="stylesheet" href="http://<?php echo $domain; ?>/style.css">
</head>
<body>

<main>
    <div class="container mt-4">
        <h2>Fila de Pacientes</h2>
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
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    function carregarFila() {
        $.ajax({
            url: 'http://localhost:3001/fila',
            method: 'GET',
            success: function(response) {
                $('#tabelaFila').empty();

                response.forEach(function(paciente) {
                    if (!paciente.validacoes.atendido) {
                        var newRow = $('<tr>');
                        newRow.append('<td>' + paciente.paciente.nome + '</td>');
                        newRow.append('<td>' + paciente.idade + '</td>');
                        newRow.append('<td>' + paciente.tipoAtendimento + '</td>');
                        var dataHora = new Date(paciente.dataHoraRecepcao);
                        var dataFormatada = dataHora.toLocaleDateString('pt-BR');
                        var horaFormatada = dataHora.toLocaleTimeString('pt-BR');
                        newRow.append('<td>' + dataFormatada + '<br>' + horaFormatada + '</td>');
                        newRow.append('<td>' + paciente.profissional.nome + '</td>');
                        newRow.append('<td>' +
                            '<button type="button" class="btn ml-2 btn-success chamarBtn" data-id="' + paciente._id + '">Chamar</button>' +
                            '<button type="button" class="btn ml-2 btn-danger cancelarBtn" data-id="' + paciente._id + '">Cancelar</button>' +
                            '</td>');
                        $('#tabelaFila').append(newRow);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar a fila de pacientes:', error);
            }
        });
    }

    $(document).ready(function() {
        carregarFila();
    });

    $(document).on('click', '.chamarBtn', function() {
        var pacienteId = $(this).data('id');
        $.ajax({
            url: 'http://localhost:3001/fila/editar' + pacienteId,
            method: 'PUT',
            success: function(response) {
                console.log('Paciente chamado com sucesso');
                carregarFila();
            },
            error: function(xhr, status, error) {
                console.error('Erro ao chamar o paciente:', error);
            }
        });
    });

    $(document).on('click', '.cancelarBtn', function() {
        var pacienteId = $(this).data('id');
        $.ajax({
            url: 'http://localhost:3001/fila/' + pacienteId,
            method: 'DELETE',
            success: function(response) {
                console.log('Paciente cancelado com sucesso');
                carregarFila(); // Recarrega a fila após o cancelamento do paciente
            },
            error: function(xhr, status, error) {
                console.error('Erro ao cancelar o paciente:', error);
            }
        });
    });
</script>

<?php
    include '../partials/footer.php';
?>
</body>
</html>

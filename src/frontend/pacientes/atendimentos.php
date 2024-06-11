<?php
    require __DIR__ . '/../vendor/autoload.php';
    use Dotenv\Dotenv;
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();                                                        
    $apiKey = $_ENV['API_KEY'];//keys necessárias para requerer dados da API


// lógica da requisicao  ##############################################################
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost:3001/pacientes");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["x-api-key: $apiKey"]);

    $respostaPacientes = curl_exec($ch);
    curl_close($ch);

    $pacientes = json_decode($respostaPacientes, true);


    $chAtendimentos = curl_init();

    curl_setopt($chAtendimentos, CURLOPT_URL, "http://localhost:3001/atendimentos/");
    curl_setopt($chAtendimentos, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($chAtendimentos, CURLOPT_HTTPHEADER, ["x-api-key: $apiKey"]);

    $respostaAtendimentos = curl_exec($chAtendimentos);

    $atendimentos = json_decode($respostaAtendimentos, true);

    curl_close($chAtendimentos);

// ################################################################

    include '../partials/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atendimentos</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <link rel="stylesheet" href="<?php echo $domain; ?>/style.css">

  <script src="https://code.jquery.com/jquery-4.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<style>
  .modal-lg {
    max-width: 90%;
  }
  .descricao {
    text-align: center;
  }

  .descricao td {
    vertical-align: middle;
  }
  .acs{
    width: 100%;
  }
</style>

<body>
    <div class="container mb-3">
    <h2>Filtrar Paciente</h2>
        <input type="text" id="filtroNome" class="form-control" placeholder="Digite nome ou SUS do paciente">
    </div>

    <div class="container">
        <h1>Atendimentos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Paciente</th>
                    <th scope="col">SUS</th>
                    <th scope="col">Médico</th>
                    <th scope="col">Data</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($atendimentos) && !empty($atendimentos)): ?>
                    <?php foreach ($atendimentos as $atendimento): ?>
                        <tr>
                            <td><?php echo !empty($atendimento['paciente']['nome']) ? htmlspecialchars($atendimento['paciente']['nome']) : 'Não informado'; ?></td>
                            <td><?php echo !empty($atendimento['paciente']['sus']) ? htmlspecialchars($atendimento['paciente']['sus']) : 'Não informado'; ?></td>
                            <td><?php echo !empty($atendimento['medico']['nome']) ? htmlspecialchars($atendimento['medico']['nome']) : 'Não informado'; ?></td>
                            <td><?php echo !empty($atendimento['data']) ? htmlspecialchars(date('d/m/Y', strtotime($atendimento['data']))) : 'Não informado'; ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="visualizarAtendimento('<?php echo $atendimento['_id']; ?>')">Visualizar</button>
                                <button class="btn btn-primary" onclick="exameMedico('<?php echo $atendimento['_id']; ?>', '<?php echo $atendimento['paciente']['id']; ?>', '<?php echo $atendimento['medico']['_id']; ?>')">Exames</button>
                                <button class="btn btn-primary" onclick="receitaMedica('<?php echo $atendimento['_id']; ?>')">Receita</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Nenhum atendimento encontrado para este paciente.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    function exameMedico(atendimentoId, pacienteId, medicoId) {
        setupModal(atendimentoId, pacienteId, medicoId); 

        $('#registrarExameModal').data('atendimentoId', atendimentoId);
        $('#registrarExameModal').data('pacienteId', pacienteId);
        $('#registrarExameModal').data('medicoId', medicoId);

        $('#solicitarExameModal').data('atendimentoId', atendimentoId);
        $('#solicitarExameModal').data('pacienteId', pacienteId);
        $('#solicitarExameModal').data('medicoId', medicoId);

        console.log('Modal setup com os IDs:', { atendimentoId, pacienteId, medicoId });

        $.ajax({
            url: `http://localhost:3001/solicitacaoExames/${atendimentoId}`,
            type: 'GET',
            headers: {
                'x-api-key': '<?php echo addslashes($apiKey); ?>'
            },
            success: function(response) {
                if (response.exists) {
                    var modalBody = $('#registrarExameModal .modal-body');
                    $('#registrarExameModal').modal('show');
                } else {
                    $('#solicitarExameModal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.log('Erro ao verificar a existência da solicitação de exame: ' + error);
            }
        });
    }
</script>


    <?php include './modals/registrarExame.php' ?>
    <?php include './modals/solicitarExameModal.php' ?>
    <?php include './modals/optReceita.php' ?>
    <?php include './modals/criarReceita.php' ?>
    <?php include './modals/visualizarAtendimento.php' ?>

    <script>
        $(document).ready(function() {
            $('#filtroNome').on('input', function() {
                var filtroNome = $(this).val().toLowerCase();
                $('tbody tr').each(function() {
                    var nomepaciente = $(this).find('td:nth-child(1)').text().toLowerCase();
                    var sus = $(this).find('td:nth-child(2)').text().toLowerCase();
                    var data = $(this).find('td:nth-child(2)').text().toLowerCase();
                    if (nomepaciente.includes(filtroNome) || sus.includes(filtroNome) || data.includes(filtroNome)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
        
    </script>

    <script>
        $(document).ready(function() {
            $('#filtroNome').on('input', function() {
                var filtroNome = $(this).val().toLowerCase();
                filtrarAtendimentos(filtroNome);
            });

            function filtrarAtendimentos(filtro) {
                $('tbody tr').each(function() {
                    var nomePaciente = $(this).find('td:nth-child(1)').text().toLowerCase();
                    var susPaciente = $(this).find('td:nth-child(2)').text().toLowerCase();
                    if (nomePaciente.includes(filtro) || susPaciente.includes(filtro)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            var urlParams = new URLSearchParams(window.location.search);
            var pacienteId = urlParams.get('pacienteId');
            if (pacienteId) {
                $('#filtroNome').val(pacienteId).trigger('input');
            }
        });
    </script>


    <?php
        include './logicas.php'
    ?>
</body>
</html>

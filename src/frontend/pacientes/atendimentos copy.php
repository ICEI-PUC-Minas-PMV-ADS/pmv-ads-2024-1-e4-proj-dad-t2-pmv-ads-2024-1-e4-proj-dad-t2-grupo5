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
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["x-api-key: $apiKey"]);

    $respostaPacientes = curl_exec($ch);
    curl_close($ch);

    $pacientes = json_decode($respostaPacientes, true);

// lógica para buscar todos os atendimentos de um paciente específico via API  ##########

// Aqui ele verifica se o Paciente ID está presente na URL
    if (isset($_GET['pacienteId'])) {
        $pacienteId = $_GET['pacienteId'];
    } else if (isset($_POST['pacienteId'])) {
        $pacienteId = $_POST['pacienteId'];
    }
    $atendimentos = [];

// Verifica se o $pacienteId está definido antes de buscar os atendimentos do paciente
    if ($pacienteId !== null) {
        $chAtendimentos = curl_init();

        curl_setopt($chAtendimentos, CURLOPT_URL, "http://localhost:3001/atendimentos/paciente/$pacienteId");
        curl_setopt($chAtendimentos, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chAtendimentos, CURLOPT_HTTPHEADER, ["x-api-key: $apiKey"]);

        $respostaAtendimentos = curl_exec($chAtendimentos);

        $atendimentos = json_decode($respostaAtendimentos, true);

        curl_close($chAtendimentos);
    }

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
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
        <h2>Selecione um Paciente</h2>
        <select id="selectPaciente" class="form-control">
            <option value="">Selecione um paciente</option>
            <?php foreach ($pacientes as $paciente): ?>
                <option value="<?php echo $paciente['_id']; ?>" <?php if($pacienteId == $paciente['_id']) echo 'selected'; ?>><?php echo htmlspecialchars($paciente['nome']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="container">
        <h1>Atendimentos do Paciente</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Paciente</th>
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
                            <td><?php echo !empty($atendimento['medico']['nome']) ? htmlspecialchars($atendimento['medico']['nome']) : 'Não informado'; ?></td>
                            <td><?php echo !empty($atendimento['data']) ? htmlspecialchars(date('d/m/Y', strtotime($atendimento['data']))) : 'Não informado'; ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="visualizarAtendimento('<?php echo $atendimento['_id']; ?>')">Visualizar</button>
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

    <div class="modal fade" id="receitaMedicaModal" tabindex="-1" role="dialog" aria-labelledby="receitaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receitaMedicaModalLabel">Receita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Btn dinâmico -->
                </div>
            </div>
        </div>
    </div>

    <?php include './modals/criarReceita.php' ?>
    <?php include './modals/visualizarAtendimento.php' ?>

    <script>
        $('#selectPaciente').change(function() {
            var pacienteId = $(this).val();
            if (pacienteId !== '') {
                window.location.href = '?pacienteId=' + pacienteId;
            } else {
                $('#tabelaAtendimentos tbody').empty();
            }
        });
    </script>

    <?php
        include './logicas.php'
    ?>
</body>
</html>

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
        function receitaMedica(atendimentoId) {
            $.ajax({
                url: `http://localhost:3001/receita/atendimento/${atendimentoId}`,
                type: 'GET',
                headers: {
                    'x-api-key': '<?php echo addslashes($apiKey); ?>'
                },
                success: function(data) {
                    var modalBody = $('#receitaMedicaModal .modal-body');
                    modalBody.empty();
                    if (data && data.length > 0) {
                        var receita = data[0];
                        modalBody.append(`<button class="btn btn-primary imprimirReceitaBtn acs" data-receita='${JSON.stringify(receita)}'>Imprimir</button>`);
                    } else {
                        modalBody.append(`<button class="btn btn-primary acs" onclick="emitirReceita('${atendimentoId}')">Emitir</button>`);
                    }
                    $('#receitaMedicaModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log('Erro ao carregar as receitas: ' + error);
                }
            });
        }

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('imprimirReceitaBtn')) {
                var receita = JSON.parse(event.target.getAttribute('data-receita'));
                imprimirReceita(receita);
            }
        });


        function imprimirReceita(receita) {
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            iframe.onload = function() {
                var doc = iframe.contentDocument || iframe.contentWindow.document;
                var dataInicio = new Date(receita.dataInicio).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                var dataFim = new Date(receita.dataFim).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });

                var html = `
                    <h2>Detalhes da Receita</h2>
                    <p><strong>Paciente:</strong> ${receita.atendimentoRef.paciente.nome}</p>
                    <p><strong>Médico:</strong> ${receita.atendimentoRef.medicoId.nome}</p>
                    <p><strong>Data Início:</strong> ${dataInicio}</p>
                    <p><strong>Data Fim:</strong> ${dataFim}</p>
                    <h3>Medicamentos:</h3>
                    <ul>
                        ${receita.medicamentos.map(medic => `<li>${medic.nome} | Quantidade: ${medic.quantidade} | Período: ${medic.periodo}</li>`).join('')}
                    </ul>
                    <p><strong>Observações:</strong> ${receita.observacoes}</p>
                `;

                doc.open();
                doc.write(html);
                doc.close();

                setTimeout(function() {
                    iframe.contentWindow.print();
                    document.body.removeChild(iframe);
                }, 500);
            };

            iframe.srcdoc = "about:blank";
        }


        $('#selectPaciente').change(function() {
            var pacienteId = $(this).val();
            if (pacienteId !== '') {
                // Aqui ele incrementa o ID do pacient ao link para facilitar a navegação entre os dados....
                window.location.href = '?pacienteId=' + pacienteId;
            } else {
                $('#tabelaAtendimentos tbody').empty();
            }
        });

        

        function visualizarAtendimento(atendimentoId) {
            $.ajax({
                url: `http://localhost:3001/atendimentos/${atendimentoId}`,
                type: 'GET',
                headers: {
                    'x-api-key': '<?php echo $apiKey; ?>'
                },
                success: function(data) {
                    var atendimento = data[0];

                    if (atendimento) { 
                        var nomeMedico = atendimento.medico ? atendimento.medico.nome : 'Não informado';
                        var crmMedico = atendimento.medico ? atendimento.medico.crm : 'Não informado';
                        var nomePaciente = atendimento.paciente ? atendimento.paciente.nome : 'Não informado';
                        var sexoPaciente = atendimento.paciente ? atendimento.paciente.sexo : 'Não informado';
                        var susPaciente = atendimento.paciente ? atendimento.paciente.sus : 'Não informado';
                        var enderecoPaciente = atendimento.paciente ? `${atendimento.paciente.logradouro}, ${atendimento.paciente.numero} <br> ${atendimento.paciente.bairro} <br> ${atendimento.paciente.cidade} / ${atendimento.paciente.estado}` : 'Não informado';

                        if ($('#dadosMedico').length) {
                            $('#dadosMedico').html(
                                `<h5>Dados do médico</h5>
                                <p>Nome: ${nomeMedico}</p>
                                <p>CRM: ${crmMedico}</p>`
                            );
                        }

                        if ($('#dadosPaciente').length) {
                            $('#dadosPaciente').html(
                                `<h5>Dados do paciente</h5>
                                <p>Nome: ${nomePaciente}</p>
                                <p>SUS: ${susPaciente}</p>
                                <p>Sexo: ${sexoPaciente}</p>
                                <p>Endereço: ${enderecoPaciente}</p>`
                            );
                        }

                        if ($('#descricaoAtendimento').length) {
                            $('#descricaoAtendimento').html(
                                `<h5>Descrição do Atendimento</h5>
                                <p>${atendimento.descricao || 'Não informado'}</p>`
                            );
                        }

                        $('#visualizarAtendimentoModal').modal('show');
                    } else {
                        console.log('Nenhum atendimento encontrado para o ID fornecido.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Erro ao carregar detalhes do atendimento: ' + error);
                    if ($('#visualizarAtendimentoModal .modal-body').length) {
                        $('#visualizarAtendimentoModal .modal-body').html(`<p>Erro ao carregar detalhes do atendimento: ${error}</p>`);
                    }
                    $('#visualizarAtendimentoModal').modal('show');
                }
            });
        }
    </script>
</body>
</html>

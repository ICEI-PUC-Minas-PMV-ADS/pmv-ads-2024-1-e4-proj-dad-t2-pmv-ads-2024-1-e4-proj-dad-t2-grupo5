<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Obtém a chave da API do ambiente
$apiKey = $_ENV['API_KEY'];

include '../partials/header.php';


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://vivabemapi.vercel.app/estoque");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "x-api-key: $apiKey"
));

$resposta = curl_exec($ch);

curl_close($ch);

$estoque = json_decode($resposta, true);

if (!$estoque || curl_errno($ch)) {
    // die('Erro ao acessar a API: ' . curl_error($ch));
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $domain; ?>/style.css">
</head>

<body>
<style>
.circle {
  height: 10px;
  width: 10px;
  border-radius: 50%;
  display: inline-block;
  margin-right: 5px;
}
.green { background-color: green; }
.gold { background-color: gold; }
.darkorange { background-color: DarkOrange; }
.red { background-color: red; }
.blue { background-color: blue; }
</style>

<main>
    
    <div class="container mt-4">
        <!-- Filtro de texto -->
        <div class="form-group">
            <label for="filtroTexto">Filtrar por texto:</label>
            <input type="text" class="form-control" id="filtroTexto">
        </div>

        <h2>Estoque</h2>

        <button type="button" class="btn btn-danger mb-3" id="btnSolicitarReposicao">
            Solicitar Reposição
        </button>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#solicitarMedicamentoModal">
            Solicitar Medicamento Excepcional
        </button>
        <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#saidaMedicamentoModal">
            Saída de Medicamento
        </button>
        <div class="legenda mt-4">
            <ul style="list-style-type: none;">
                <li><span style="color: DarkOrange; font-weight: bold;"><span style="height: 10px; width: 10px; background-color: DarkOrange; border-radius: 50%; display: inline-block;"></span> Estoques baixos</span></li>
                <li><span style="color: red; font-weight: bold;"><span style="height: 10px; width: 10px; background-color: red; border-radius: 50%; display: inline-block;"></span> Estoque em falta / sem validade</span></li>
                <li><span style="color: blue; font-weight: bold;"><span style="height: 10px; width: 10px; background-color: blue; border-radius: 50%; display: inline-block;"></span> Menos de 60 dias para o medicamento vencer</span></li>
                <li><span style="color: Gold; font-weight: bold;"><span style="height: 10px; width: 10px; background-color: Gold; border-radius: 50%; display: inline-block;"></span> Medicamento Vencido</span></li>
                <li><span style="color: Green; font-weight: bold;"><span style="height: 10px; width: 10px; background-color: Green; border-radius: 50%; display: inline-block;"></span> Quantidade ou Validade OK</span></li>    
            </ul> 
        </div>

        <table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Código</th>
            <th>Quantidade</th>
            <th>Validade</th>
            <th>Situação</th>
        </tr>         
    </thead>
    <tbody id="tabelaEstoque">
        <?php if (!empty($estoque)): ?>
            <?php foreach ($estoque as $medicamento): ?>
                <tr>
                    <td style="font-weight: bold;"><?php echo htmlspecialchars($medicamento['nome']); ?></td>
                    <td style="font-weight: bold;"><?php echo htmlspecialchars($medicamento['codigo']); ?></td>
                    <td style="color: 
                    <?php
                        if ($medicamento['quantidade'] == 0) {
                            echo 'red'; 
                        } elseif ($medicamento['quantidade'] >= 1 && $medicamento['quantidade'] <= 5) {
                            echo 'DarkOrange'; 
                        } else {
                            echo 'black';
                        }
                    ?>;
                        font-weight: bold;
                    ">
                    <?php echo htmlspecialchars($medicamento['quantidade']); ?>
                    </td>
                    <td style="color: 
                    <?php
                        $validade_raw = $medicamento['validade'] ?? null; 

                        if (!empty($validade_raw)) {
                            $validade = new DateTime($validade_raw);
                            $hoje = new DateTime();
                            $intervalo = $validade->diff($hoje)->days;

                            if ($validade < $hoje) {
                                echo 'Gold';  
                            } elseif ($intervalo <= 60) {
                                echo 'blue';  
                            } else {
                                echo 'black'; 
                            }
                        } else {
                            echo 'red'; 
                        }
                    ?>;
                    font-weight: bold;">
                    <?php
                        if (!empty($validade_raw)) {
                            echo htmlspecialchars($validade->format('d/m/Y'));
                        } else {
                            echo 'Não informado'; 
                        }
                    ?>
                </td>
                <td>
                    <span class="circle <?php echo ($medicamento['quantidade'] == 0) ? 'red' : (($medicamento['quantidade'] >= 1 && $medicamento['quantidade'] <= 5) ? 'darkorange' : 'green'); ?>"></span>
                    <span class="circle <?php 
                        $validade_raw = $medicamento['validade'] ?? null;

                        if ($validade_raw === null) {
                            echo 'Red';
                        } else {
                            $validade = new DateTime($validade_raw);
                            $hoje = new DateTime();
                            $intervalo = $validade->diff($hoje)->days;

                            if ($validade < $hoje) {
                                echo 'Gold';
                            } elseif ($intervalo <= 60) {
                                echo 'Blue';
                            } else {
                                echo 'Green';
                            }
                        }
                    ?>">
                    </span>

                </td>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Nenhum medicamento encontrado.</td>
        </tr>
    <?php endif; ?>
</tbody>
</table>
    </div>
</main>

<!-- Modal de Edição de Medicamento -->
<div class="modal fade" id="editarMedicamentoModal" tabindex="-1" role="dialog" aria-labelledby="editarMedicamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarMedicamentoModalLabel">Editar Medicamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarMedicamentoForm">
                    <input type="hidden" id="editarIdMedicamento" name="id">
                    <div class="form-group">
                        <label for="editarNomeMedicamento">Nome:</label>
                        <input type="text" class="form-control" id="editarNomeMedicamento" name="nome">
                    </div>
                    <div class="form-group">
                        <label for="editarCodigoMedicamento">Codigo:</label>
                        <input type="number" class="form-control" id="editarCodigoMedicamento" name="codigo">
                    </div>
             
                    <div class="form-group">
                        <label for="editarQuantidadeMedicamento">Quantidade:</label>
                        <input type="number" class="form-control" id="editarQuantidadeMedicamento" name="quantidade">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="excluirMedicamento">Excluir</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvarEdicaoMedicamento">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Solicitar Reposição -->
<div class="modal fade" id="solicitarReposicaoModal" tabindex="-1" role="dialog" aria-labelledby="solicitarReposicaoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="solicitarReposicaoModalLabel">Solicitar Reposição</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="solicitarReposicaoForm">
                    <div class="form-group">
                        <label for="medicamentoIdReposicao">Medicamento:</label>
                        <select class="form-control" id="medicamentoIdReposicao" required>
                            <?php foreach ($estoque as $item): ?>
                                <option value="<?= htmlspecialchars($item['_id']) ?>"><?= htmlspecialchars($item['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantidadeReposicao">Quantidade:</label>
                        <input type="number" class="form-control" id="quantidadeReposicao" required>
                    </div>
                    <div class="form-group">
                        <label for="validadeReposicao">Validade:</label>
                        <input type="date" class="form-control" id="validadeReposicao" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSolicitarReposicao">Enviar Solicitação</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Solicitar Medicamento Excepcional -->
<div class="modal fade" id="solicitarMedicamentoModal" tabindex="-1" role="dialog" aria-labelledby="solicitarMedicamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="solicitarMedicamentoModalLabel">Solicitar Medicamento Excepcional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="solicitarMedicamentoForm">
                    <div class="form-group">
                        <label for="nomeMedicamento">Nome do Medicamento:</label>
                        <input type="text" class="form-control" id="nomeMedicamento" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="enviarMedicamentoExcepcional">Enviar Solicitação</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Erro -->
<div class="modal fade" id="erroModal" tabindex="-1" aria-labelledby="erroModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="erroModalLabel">Erro ao Adicionar Medicamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="mensagemErro"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de saída de medicamento -->
<div class="modal fade" id="saidaMedicamentoModal" tabindex="-1" role="dialog" aria-labelledby="saidaMedicamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saidaMedicamentoModalLabel">Saída de Medicamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="saidaMedicamentoForm">
                    <div class="form-group">
                        <label for="medicamentoId">Medicamento:</label>
                        <select class="form-control" id="medicamentoId" required>
                            <?php foreach ($estoque as $item): ?>
                                <option value="<?= htmlspecialchars($item['_id']) ?>"><?= htmlspecialchars($item['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantidadeSaida">Quantidade:</label>
                        <input type="number" class="form-control" id="quantidadeSaida" required>
                    </div>
                    <div class="form-group">
                        <label for="pacienteId">Paciente:</label>
                         <select class="form-control" id="pacienteId" required></select>
                    </div>
                    <div class="form-group">
                        <label for="nomeMedico">Nome do Médico:</label>
                        <input type="text" class="form-control" id="nomeMedico" required>
                    </div>
                    <div class="form-group">
                        <label for="crmMedico">CRM do Médico:</label>
                        <input type="text" class="form-control" id="crmMedico" required>
                    </div>
                    <div class="form-group">
                        <label for="dataReceita">Data da Receita:</label>
                        <input type="date" class="form-control" id="dataReceita" required>
                    </div>
                    <div class="form-group">
                    <label for="dataSaida">Data da Saída:</label>
                         <input type="text" class="form-control" id="dataSaida" readonly>
                    </div>
                    <div class="form-group">
                        <label for="horaSaida">Hora da Saída:</label>
                        <input type="text" class="form-control" id="horaSaida" readonly>
                    </div>

                    <div class="form-group">
                        <label for="numeroReceita">Número da Receita:</label>
                        <input type="text" class="form-control" id="numeroReceita" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="finalizarSaidaMedicamento">Salvar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('#filtro').change(function() {
        var filtro = $(this).val();
        var filtroTexto = $('#filtroTexto').val(); 
        window.location.href = 'index.php?filtro=' + filtro + '&filtroTexto=' + filtroTexto;
    });

    $('#filtroTexto').on('input', function() {
        var filtroTexto = $(this).val().toLowerCase();
        $('#tabelaEstoque tr').each(function() {
            var nome = $(this).find('td:nth-child(1)').text().toLowerCase();
            var codigo = $(this).find('td:nth-child(2)').text().toLowerCase();
            if (nome.includes(filtroTexto) || codigo.includes(filtroTexto)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

// solicitação de reposição de medicamento 
document.getElementById('btnSolicitarReposicao').addEventListener('click', async () => {
        try {

            alert('Reposição Solicitada com Sucesso');

            const response = await fetch('https://vivabemapi.vercel.app/reposicao/repor-medicamentos/6622c3ef98ae18494d3f25e5', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({}) 
            });

            if (response.ok) {
                console.log('Reposição solicitada com sucesso!');
            } else {
                console.error('Erro ao solicitar reposição:', response.status);
                console.error('Detalhes do erro:', await response.text());
                alert('Erro ao solicitar reposição. Verifique o console para mais detalhes.');
            }
        } catch (error) {
            console.error('Erro ao solicitar reposição:', error);
            alert('Erro ao solicitar reposição. Verifique o console para mais detalhes.');
        }
});



$('#enviarMedicamentoExcepcional').on('click', async function() {
    var nome = $('#nomeMedicamento').val();

    var dadosMedicamento = {
        nome: nome,
        quantidade: 0
    };

    try {
        const response = await fetch('https://vivabemapi.vercel.app/estoque/medicamentos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dadosMedicamento)
        });

        if (response.ok) {
            alert('Medicamento excepcional solicitado com sucesso!');
            $('#solicitarMedicamentoModal').modal('hide');
            location.reload(); 
        } else {
            const erroMsg = await response.text();
            throw new Error(erroMsg);
        }
    } catch (error) {
        console.error('Erro ao solicitar o medicamento excepcional:', error);
        alert('Erro ao solicitar o medicamento excepcional. Verifique o console para mais detalhes.');
    }
});

$(document).ready(function() {
    
    function carregarPacientes() {
        fetch('https://vivabemapi.vercel.app/pacientes')
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Erro ao buscar pacientes.');
            })
            .then(data => {
                const pacienteSelect = $('#pacienteId');
                pacienteSelect.empty();
                data.forEach(paciente => {
                    pacienteSelect.append(`<option value="${paciente._id}">${paciente.nome}</option>`);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar os pacientes:', error);
                alert('Erro ao carregar os pacientes. Verifique o console para mais detalhes.');
            });
    }

    
    $('#saidaMedicamentoModal').on('show.bs.modal', function(e) {
        carregarPacientes();
        const now = new Date();
        $('#dataSaida').val(now.toLocaleDateString('pt-BR'));
        $('#horaSaida').val(now.toLocaleTimeString('pt-BR'));
    });

    $('#finalizarSaidaMedicamento').on('click', async function() {
        var idMedicamento = $('#medicamentoId').val();
        var quantidadeSaida = parseInt($('#quantidadeSaida').val());
        // até aqui funfou
        var dadosSaida = {
            medicamento: $('#medicamentoId').val(),
            quantidade: parseInt($('#quantidadeSaida').val()),
            paciente: $('#pacienteId').val(),
            nomeMedico: $('#nomeMedico').val(),
            crmMedico: $('#crmMedico').val(),
            dataReceita: $('#dataReceita').val(),
            numeroReceita: $('#numeroReceita').val(),
            dataSaida: $('#dataSaida').val(),
            horaSaida: $('#horaSaida').val()
        };
        try {
            const responseSaida = await fetch('https://vivabemapi.vercel.app/saidamed', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dadosSaida)
            });
            const estoqueResponse = await fetch(`https://vivabemapi.vercel.app/estoque/medicamento/${idMedicamento}`);
            const medicamentoResposta = await estoqueResponse.json();
            const medicamento = medicamentoResposta[0]
            
            
            console.log('medicamento fora do array', medicamento)

            if (medicamento.quantidade < quantidadeSaida) {
                alert('Quantidade em estoque insuficiente para a saída.');
                return;
            }

            var dadosAtualizados = {
                nome: medicamento.nome,
                codigo: medicamento.codigo,
                quantidade: medicamento.quantidade - quantidadeSaida,
            };

            const response = await fetch(`https://vivabemapi.vercel.app/estoque/medicamento/${idMedicamento}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dadosAtualizados)
            });

            if (response.ok) {
                alert('Saída de medicamento registrada e estoque atualizado com sucesso!');
                $('#saidaMedicamentoModal').modal('hide');
                location.reload();
            } else {
                const erroMsg = await response.text();
                throw new Error(erroMsg);
            }
        } catch (error) {
            console.error('Erro ao registrar a saída de medicamento:', error);
            alert('Erro ao registrar a saída de medicamento. Verifique o console para mais detalhes.');
        }
    });
});


</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<?php
include '../partials/footer.php';
?>

</body>
</html>
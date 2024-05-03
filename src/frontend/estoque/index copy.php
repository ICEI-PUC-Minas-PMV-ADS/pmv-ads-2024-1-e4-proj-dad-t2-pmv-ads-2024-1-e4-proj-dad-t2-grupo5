<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Obtém a chave da API do ambiente
$apiKey = $_ENV['API_KEY'];

include '../partials/header.php';


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost:3001/estoque");
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

        <table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Código</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>         
    </thead>
    <tbody id="tabelaEstoque">
    <?php if (!empty($estoque)): ?>
        <?php foreach ($estoque as $medicamento): ?>
            <tr>
                <td><?php echo htmlspecialchars($medicamento['nome']); ?></td>
                <td><?php echo htmlspecialchars($medicamento['codigo']); ?></td>
                <td style="color: <?php echo $medicamento['quantidade'] < 5 ? 'red' : 'green'; ?>">
                    <?php echo htmlspecialchars($medicamento['quantidade']); ?>
                </td>
                <td>
                    <button class="btn btn-info btn-sm editarBtn" data-id="<?php echo $medicamento['_id']; ?>" data-nome="<?php echo htmlspecialchars($medicamento['nome']); ?>" data-codigo="<?php echo htmlspecialchars($medicamento['codigo']); ?>" data-quantidade="<?php echo htmlspecialchars($medicamento['quantidade']); ?>">Editar</button>
                </td>
            </tr>
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


<script>
    $(document).ready(function() {
        // Função para carregar pacientes
        function carregarPacientes() {
            fetch('http://localhost:3001/pacientes')
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

        // Preparar data e hora ao abrir a modal
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
                const responseSaida = await fetch('http://localhost:3001/saidamed', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dadosSaida)
                });
                const estoqueResponse = await fetch(`http://localhost:3001/estoque/medicamento/${idMedicamento}`);
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

                const response = await fetch(`http://localhost:3001/estoque/medicamento/${idMedicamento}`, {
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

        $(document).ready(function() {
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


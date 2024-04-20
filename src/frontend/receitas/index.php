<?php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Obtém a chave da API do ambiente
$apiKey = $_ENV['API_KEY'];

include '../partials/header.php';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost:3001/receita");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "x-api-key: $apiKey"
));

$resposta = curl_exec($ch);

curl_close($ch);

$receita = json_decode($resposta, true);

if (!$receita || curl_errno($ch)) {
    // die('Erro ao acessar a API: ' . curl_error($ch));
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Receitas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://<?php echo $domain; ?>/style.css">
</head>
<body>

<main>
    <div class="container mt-4">
        <!-- Filtro de texto -->
        <div class="form-group">
            <label for="filtroTexto">Filtrar por texto:</label>
            <input type="text" class="form-control" id="filtroTexto">
        </div>

        <h2>Receita</h2>
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#adicionarMedicamentoModal">
            Adicionar Receita
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Ações</th>
                    <th>Imprimir</th>
                </tr>         
            </thead>
            <tbody id="tabelaEstoque">
                <?php if (!empty($receita)): ?>
                    <?php foreach ($receita as $receitaAtendimento): ?>
                        <tr>         
                            <td><?php echo htmlspecialchars($receitaAtendimento['atendimentoRef']['pacienteId']['nome']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($receitaAtendimento['dataInicio'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($receitaAtendimento['dataFim'])); ?></td>
                            <td>
                                <button type="button" class="btn btn-primary editarReceitaBtn">
                                    Editar
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary imprimirReceitaBtn" data-receita='<?php echo json_encode($receitaAtendimento); ?>'>
                                    Imprimir Receita
                                </button>
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
        $('.imprimirReceitaBtn').click(function() {
            var receita = $(this).data('receita');
            var receitaTitulo = `Receita${receita._id}${receita.atendimentoRef.pacienteId.nome}`;

            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            iframe.src = 'modelo_impressao.html';

            var dataInicio = new Date(receita.dataInicio);
            var dataFim = new Date(receita.dataFim);
            var options = { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' };


            iframe.onload = function() {
                var html = `
                    <h2>Detalhes da Receita</h2>
                    <p><strong>Paciente:</strong> ${receita.atendimentoRef.pacienteId.nome}</p>
                    <p><strong>Médico:</strong> ${receita.atendimentoRef.medicoId.nome}</p>
                    <p><strong>Data Início:</strong> ${dataInicio.toLocaleDateString('pt-BR', options)}</p>
                    <p><strong>Data Fim:</strong> ${dataFim.toLocaleDateString('pt-BR', options)}</p>
                    <h3>Medicamentos:</h3>
                    <ul>
                        ${receita.medicamentos.map(function(medicamento) {
                            return `<li>${medicamento.nome} | Quantidade: ${medicamento.quantidade} | Período: ${medicamento.periodo}</li>`;
                        }).join('')}
                    </ul>
                    <p><strong>Observações:</strong> ${receita.observacoes}</p>
                `;

                var doc = iframe.contentWindow.document;
                doc.open();
                doc.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">');
                doc.write('<link rel="stylesheet" href="style.css">');
                doc.write(html);
                doc.close();

                setTimeout(function() {
                    iframe.contentWindow.print();
                }, 2000); 


                setTimeout(function() {
                    document.body.removeChild(iframe);
                }, 20000);
            };
        });
    });
</script>






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


</body>
</html>

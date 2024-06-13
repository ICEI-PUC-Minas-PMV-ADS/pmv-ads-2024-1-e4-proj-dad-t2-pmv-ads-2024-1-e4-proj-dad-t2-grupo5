<?php
require __DIR__ . './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Obtém a chave da API do ambiente
$apiKey = $_ENV['API_KEY'];

include './partials/header.php';


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



</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<?php
include './partials/footer.php';
?>

</body>
</html>
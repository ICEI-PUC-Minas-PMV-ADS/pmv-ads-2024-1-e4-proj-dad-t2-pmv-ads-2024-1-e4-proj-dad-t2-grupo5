<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Obtém a chave da API do ambiente
$apiKey = $_ENV['API_KEY'];

include '../partials/header.php';
include '../partials/footer.php';


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
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#adicionarMedicamentoModal">
            Adicionar estoque
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Código</th>
                    <th>Preço</th>
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
                            <td><?php echo htmlspecialchars($medicamento['preco']); ?></td>
                            <td style="color: <?php echo $medicamento['quantidade'] == 0 ? 'red' : 'green'; ?>">
                                <?php echo htmlspecialchars($medicamento['quantidade']); ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary editarMedicamentoBtn" data-toggle="modal" data-target="#editarMedicamentoModal" data-id="<?php echo $medicamento['_id']; ?>" data-nome="<?php echo htmlspecialchars($medicamento['nome']); ?>" data-codigo="<?php echo htmlspecialchars($medicamento['codigo']); ?>" data-preco="<?php echo htmlspecialchars($medicamento['preco']); ?>"data-quantidade="<?php echo htmlspecialchars($medicamento['quantidade']); ?>">
                                    Editar
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
                        <label for="editarPrecoMedicamento">Preço:</label>
                        <input type="number" class="form-control" id="editarPrecoMedicamento" name="preco">
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

<!-- Modal para adicionar Medicamento -->
<div class="modal fade" id="adicionarMedicamentoModal" tabindex="-1" aria-labelledby="adicionarMedicamentoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adicionarMedicamentoModalLabel">Adicionar Medicamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="adicionarMedicamentoForm">
            <div class="form-group">
                <label for="nomeMedicamento">Nome do Medicamento</label>
                <input type="text" class="form-control" id="nomeMedicamento" name="nome">
            </div>
            <div class="form-group">
                <label for="codigoMedicamento">Código</label>
                <input type="text" class="form-control" id="codigoMedicamento" name="codigo">
            </div>
            <div class="form-group">
                <label for="precoMedicamento">Preço</label>
                <input type="number" step="0.01" class="form-control" id="precoMedicamento" name="preco">
            </div>
            <div class="form-group">
                <label for="quantidadeMedicamento">Quantidade</label>
                <input type="number" class="form-control" id="quantidadeMedicamento" name="quantidade">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="salvarMedicamento">Salvar</button>
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

    
    $('#excluirMedicamento').click(function() {
        var id = $('#editarIdMedicamento').val();
        console.log(id)

        $.ajax({
            url: 'http://localhost:3001/estoque/excluir/' + id,
            method: 'DELETE', 
            headers: {
                'x-api-key': '<?php echo $apiKey; ?>'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
            }
        });
    });    

    $(document).ready(function() {
        $('.editarMedicamentoBtn').click(function() {
            var id = $(this).data('id');
            var nome = $(this).data('nome');
            var codigo = $(this).data('codigo');
            var preco = $(this).data('preco');
            var quantidade = $(this).data('quantidade');

            $('#editarIdMedicamento').val(id);
            $('#editarNomeMedicamento').val(nome);
            $('#editarCodigoMedicamento').val(codigo);
            $('#editarPrecoMedicamento').val(preco);
            $('#editarQuantidadeMedicamento').val(quantidade);
        });

        $('#salvarEdicaoMedicamento').click(function() {
        var id = $('#editarIdMedicamento').val();
        var nome = $('#editarNomeMedicamento').val();
        var codigo = $('#editarCodigoMedicamento').val();
        var preco = $('#editarPrecoMedicamento').val();
        var quantidade = $('#editarQuantidadeMedicamento').val();

        $.ajax({
            url: `http://localhost:3001/estoque/medicamento/${id}`, // Ajuste a URL conforme necessário
            method: 'PUT', // Método HTTP apropriado para atualizações
                headers: {
                'x-api-key': '<?php echo $apiKey; ?>'
            },
            contentType: "application/json",
            data: JSON.stringify({
                nome: nome,
                codigo: codigo,
                preco: preco,
                quantidade: quantidade
            }),
            success: function(response) {
                window.location.reload();
            },
            error: function(xhr, status, error) {
            }
        });
    });
    });

$('#salvarMedicamento').on('click', function() {
    var dados = {
        nome: $('#nomeMedicamento').val(),
        codigo: $('#codigoMedicamento').val(),
        preco: $('#precoMedicamento').val(),
        quantidade: $('#quantidadeMedicamento').val(),
    };

    $.ajax({
        url: 'http://localhost:3001/estoque/medicamentos',
        type: 'POST',
        headers: {
            'x-api-key': '<?php echo $apiKey; ?>'
        },
        contentType: 'application/json',
        data: JSON.stringify(dados),
        success: function(response) {
            window.location.reload();
        },
        error: function(xhr) {
            try {
                var resposta = JSON.parse(xhr.responseText);
                var mensagemErro = resposta.message;
                $('#mensagemErro').text(mensagemErro);
            } catch(e) {
                $('#mensagemErro').text("Ocorreu um erro desconhecido ao adicionar o Medicamento.");
            }

            $('#erroModal').modal('show');
        }
    });
});


    

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


</body>
</html>

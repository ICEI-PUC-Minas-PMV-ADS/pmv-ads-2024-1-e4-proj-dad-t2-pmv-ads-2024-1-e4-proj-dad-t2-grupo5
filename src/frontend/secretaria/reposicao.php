<?php

include '../partials/header.php';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost:3001/reposicao");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

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
    <title>Gerenciar Solicitações de Reposição</title>
    <link rel="stylesheet"href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $domain; ?>/style.css">
</head>
<body>

<main>
    <h1 class="mt-4 mb-3">Reposição da Unidade 1</h1>
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#adicionarMedicamentoModal">
            Adicionar Estoque
        </button>
    <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Código</th>
                            <th>Quantidade Disponível</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="listaMedicamentos">
                    </tbody>
                </table>
</main>


<div class="modal fade" id="modalEditarMedicamento" tabindex="-1" aria-labelledby="modalEditarMedicamentoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarMedicamentoLabel">Editar Medicamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarMedicamento">
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
                <label for="quantidadeMedicamento">Quantidade</label>
                <input type="number" class="form-control" id="quantidadeMedicamento" name="quantidade">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success" id="salvarMedicamento">Salvar</button>
      </div>
    </div>
  </div>
</div>
  

<!-- editar medicamento -->
<script>
$(document).ready(function() {
    $('#modalEditarMedicamento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var id = button.data('medicamento-id'); 
        var nome = button.closest('tr').find('td:eq(0)').text();
        var codigo = button.closest('tr').find('td:eq(1)').text();
        var quantidade = button.closest('tr').find('td:eq(2)').text();

        var modal = $(this);
        modal.find('#editarIdMedicamento').val(id);
        modal.find('#editarNomeMedicamento').val(nome);
        modal.find('#editarCodigoMedicamento').val(codigo);
        modal.find('#editarQuantidadeMedicamento').val(quantidade);
    });

    $('#salvarEdicaoMedicamento').click(function() {
        var id = $('#editarIdMedicamento').val();
        var nome = $('#editarNomeMedicamento').val();
        var codigo = $('#editarCodigoMedicamento').val();
        var quantidade = $('#editarQuantidadeMedicamento').val();

        $.ajax({
            url: `http://localhost:3001/estoque/medicamento/${id}`,
            method: 'PUT',
            contentType: "application/json",
            data: JSON.stringify({
                nome: nome,
                codigo: codigo,
                quantidade: quantidade
            }),
            success: function(response) {
                $.ajax({
                    url: 'http://localhost:3001/reposicao/repor-medicamentos/6622c3ef98ae18494d3f25e5',
                    method: 'PUT',
                    contentType: 'application/json',
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        
    });
});



</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
include '../partials/footer.php';
?>

</body>
</html>

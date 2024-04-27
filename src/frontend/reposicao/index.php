<?php



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost:3001/reposicao");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resposta = curl_exec($ch);

curl_close($ch);

$estoque = json_decode($resposta, true);

if (!$estoque || curl_errno($ch)) {
    // die('Erro ao acessar a API: ' . curl_error($ch));
}
include '../partials/header.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Solicitações de Reposição</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-4 mb-3">Gestão de Unidade 1</h1>
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
</div>


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
  
<!-- criar e popular a tabela -->
<script>

    $(document).ready(function() {
        $('#salvarMedicamento').on('click', function() {
            var dados = {
                nome: $('#nomeMedicamento').val(),
                codigo: $('#codigoMedicamento').val(),
                quantidade: $('#quantidadeMedicamento').val(),
            };

            console.log(dados);
            $.ajax({
                url: 'http://localhost:3001/estoque/medicamentos',
                type: 'POST',
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
    });


    async function preencherListaMedicamentos() {
        try {
            const response = await fetch('http://localhost:3001/reposicao/');
            if (!response.ok) {
                throw new Error('Erro ao buscar medicamentos solicitados: ' + response.statusText);
            }
            const medicamentos = await response.json();

            console.log(medicamentos)

            const listaMedicamentos = document.getElementById('listaMedicamentos');
            listaMedicamentos.innerHTML = '';

            medicamentos[0].medicamentos.forEach(medicamento => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${medicamento.nome}</td>
                    <td>${medicamento.codigo}</td>
                    <td>${medicamento.quantidadeAtual}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarMedicamento" data-medicamento-id="${medicamento._id}">
                            Editar
                        </button>
                    </td>
                `;
                listaMedicamentos.appendChild(row);
            });
        } catch (error) {
            console.error(error);
            alert('Erro ao buscar medicamentos solicitados. Verifique o console para mais detalhes.');
        }
    }



    preencherListaMedicamentos();

    document.getElementById('formEditarMedicamento').addEventListener('submit', async (event) => {
        event.preventDefault();
        document.getElementById('modalEditarMedicamento').classList.remove('show');
        document.getElementById('modalEditarMedicamento').setAttribute('aria-hidden', 'true');
        document.querySelector('.modal-backdrop').remove();
    });
</script>

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

// $('#excluirMedicamento').click(function() {
//         var id = $('#editarIdMedicamento').val();
//         console.log(id)

//         $.ajax({
//             url: 'http://localhost:3001/estoque/excluir/' + id,
//             method: 'DELETE', 
//             success: function(response) {
//                 location.reload();
//             },
//             error: function(xhr, status, error) {
//             }
//         });
//     }); 

</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>

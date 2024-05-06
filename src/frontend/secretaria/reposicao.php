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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $domain; ?>/style.css">
</head>
<body>

<div class="container">
    <h1 class="mt-4 mb-3">Reposição de Medicamentos Unidade 1</h1>
    <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#adicionarMedicamentoModal">
        Adicionar Estoque
    </button>
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Código</th>
                <th>Quantidade Disponível</th>
                <th>Validade</th>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarMedicamento">
                    <input type="hidden" id="editarIdMedicamento" name="id">
                    <div class="form-group">
                        <label for="editarNomeMedicamento">Nome:</label>
                        <input type="text" class="form-control" id="editarNomeMedicamento" name="nome">
                    </div>
                    <div class="form-group">
                        <label for="editarCodigoMedicamento">Código:</label>
                        <input type="number" class="form-control" id="editarCodigoMedicamento" name="codigo">
                    </div>
                    <div class="form-group">
                        <label for="editarQuantidadeMedicamento">Quantidade:</label>
                        <input type="number" class="form-control" id="editarQuantidadeMedicamento" name="quantidade">
                    </div>
                    <div class="form-group">
                        <label for="editarValidadeMedicamento">Validade:</label>
                        <input type="date" class="form-control" id="editarValidadeMedicamento" name="validade">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="salvarEdicaoMedicamento">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
async function preencherListaMedicamentos() {
    try {
        const response = await fetch('http://localhost:3001/reposicao/');
        if (!response.ok) {
            throw new Error('Erro ao buscar medicamentos solicitados: ' + response.statusText);
        }
        const medicamentosReposicao = await response.json();
        const listaMedicamentos = document.getElementById('listaMedicamentos');

    
        if (medicamentosReposicao.length === 0) {
            listaMedicamentos.innerHTML = '<tr><td colspan="5">Nenhum medicamento necessita de reposição</td></tr>';
            return;
        }

        listaMedicamentos.innerHTML = '';
        medicamentosReposicao.forEach(reposicao => {
            reposicao.medicamentos.forEach(medicamento => {
                
                const validade = new Date(medicamento.validade);
                const validadeFormatada = validade.toLocaleDateString('pt-BR'); 

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${medicamento.nome}</td>
                    <td>${medicamento.codigo}</td>
                    <td>${medicamento.quantidadeAtual}</td>
                    <td>${validadeFormatada}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEditarMedicamento" data-medicamento-id="${medicamento._id}">
                            Editar
                        </button>
                    </td>
                `;
                listaMedicamentos.appendChild(row);
            });
        });
    } catch (error) {
        console.error(error);
        alert('Erro ao buscar medicamentos solicitados. Verifique o console para mais detalhes.');
    }
}

$(document).ready(function() {
    preencherListaMedicamentos();

    $('#modalEditarMedicamento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('medicamento-id');
        var nome = button.closest('tr').find('td:eq(0)').text();
        var codigo = button.closest('tr').find('td:eq(1)').text();
        var quantidade = button.closest('tr').find('td:eq(2)').text();
        var validade = button.closest('tr').find('td:eq(3)').text();

        var modal = $(this);
        modal.find('#editarIdMedicamento').val(id);
        modal.find('#editarNomeMedicamento').val(nome);
        modal.find('#editarCodigoMedicamento').val(codigo);
        modal.find('#editarQuantidadeMedicamento').val(quantidade);
        modal.find('#editarValidadeMedicamento').val(validade);
    });

    $('#salvarEdicaoMedicamento').on('click', async function() {
        var id = $('#editarIdMedicamento').val();
        var nome = $('#editarNomeMedicamento').val();
        var codigo = $('#editarCodigoMedicamento').val();
        var quantidade = $('#editarQuantidadeMedicamento').val();
        var validade = $('#editarValidadeMedicamento').val();

        var dadosMedicamento = {
            nome: nome,
            codigo: codigo,
            quantidade: parseInt(quantidade),
            validade: validade
        };

        // URL da API
        var url = 'http://localhost:3001/estoque/medicamento/' + id;

        try {
            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dadosMedicamento)
            });

            if (response.ok) {
                
                await fetch(`http://localhost:3001/reposicao/repor-medicamentos/6622c3ef98ae18494d3f25e5`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                alert('Medicamento atualizado com sucesso!');
                $('#modalEditarMedicamento').modal('hide');
                location.reload();
            } else {
                const erroMsg = await response.text();
                throw new Error(erroMsg);
            }
        } catch (error) {
            console.error('Erro ao atualizar o medicamento:', error);
            alert('Erro ao atualizar o medicamento. Verifique o console para mais detalhes.');
        }
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


</body>
</html>
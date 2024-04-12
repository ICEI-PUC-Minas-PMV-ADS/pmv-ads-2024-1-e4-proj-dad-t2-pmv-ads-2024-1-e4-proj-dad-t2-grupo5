
    $('#excluirMedicamento').click(function() {
        var id = $('#editarIdMedicamento').val();
        console.log(id)

        $.ajax({
            url: 'http://localhost:3001/estoque/excluir/' + id,
            method: 'DELETE', 
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
                alert('Erro ao atualizar o Medicamento: ' + error);
            }
        });
    });
    });



$('#salvarMedicamento').on('click', function() {
    var nome = $('#nomeMedicamento').val();
    var codigo = $('#codigoMedicamento').val();
    var preco = $('#precoMedicamento').val();
    var quantidade = $('#quantidadeMedicamento').val();

    var dados = {
        nome: nome,
        codigo: codigo,
        preco: preco,
        quantidade: quantidade,
    };

    $.ajax({
        url: 'http://localhost:3001/estoque/medicamentos',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(dados),
        success: function(response) {
            window.location.reload();
        },
        error: function(xhr, status, error) {
            alert('Ocorreu um erro ao adicionar o Medicamento: ' + xhr.responseText);
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

    // $(document).ready(function() {
    //     var filtroAtual = '<?php echo isset($_GET["filtroTexto"]) ? $_GET["filtroTexto"] : "" ?>';
    //     $('#filtroTexto').val(filtroAtual);
    // });

    // $(document).ready(function() {
    //     var filtroAtual = '<?php echo isset($_GET["filtro"]) ? $_GET["filtro"] : "" ?>';
    //     $('#filtro').val(filtroAtual);
    // });
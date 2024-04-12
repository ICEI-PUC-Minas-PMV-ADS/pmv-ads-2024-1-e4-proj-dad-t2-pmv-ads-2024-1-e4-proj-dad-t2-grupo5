$(document).ready(function() {
    $('.visualizarPacienteBtn').click(function() {
        var id = $(this).data('id');
        var nome = $(this).data('nome');
        var dataNascimento = $(this).data('data-nascimento');
        var sexo = $(this).data('sexo');
        var sus = $(this).data('sus');
        var pec = $(this).data('pec');
        var logradouro = $(this).data('logradouro');
        var bairro = $(this).data('bairro');
        var numero = $(this).data('numero');
        var cidade = $(this).data('cidade');
        var estado = $(this).data('estado');
        var acs = $(this).data('acs');
        var nomeMae = $(this).data('nome-mae');
        var alergias = $(this).data('alergias');
        var comorbidades = $(this).data('comorbidades');
        var telefone = $(this).data('telefone');
        var email = $(this).data('email');
        var etnia = $(this).data('etnia');
        var estadoCivil = $(this).data('estado-civil');
        var nacionalidade = $(this).data('nacionalidade');
        var profissao = $(this).data('profissao');

        $('#id').text(id);
        $('#visualizarNome').text(nome);
        $('#visualizarDataNascimento').text(dataNascimento);
        $('#visualizarSexo').text(sexo);
        $('#visualizarSUS').text(sus);
        $('#visualizarPEC').text(pec);
        $('#visualizarLogradouro').text(logradouro);
        $('#visualizarBairro').text(bairro);
        $('#visualizarNumero').text(numero);
        $('#visualizarCidade').text(cidade);
        $('#visualizarEstado').text(estado);
        $('#visualizarACS').text(acs);
        $('#visualizarNomeMae').text(nomeMae);
        $('#visualizarAlergias').text(alergias);
        $('#visualizarComorbidades').text(comorbidades);
        $('#visualizarTelefone').text(telefone);
        $('#visualizarEmail').text(email);
        $('#visualizarEtnia').text(etnia);
        $('#visualizarEstadoCivil').text(estadoCivil);
        $('#visualizarNacionalidade').text(nacionalidade);
        $('#visualizarProfissao').text(profissao);
    });
});


 $(document).ready(function() {
        $('#filtroNome').on('input', function() {
            var filtroNome = $(this).val().toLowerCase();
            $('tbody tr').each(function() {
                var nomepaciente = $(this).find('td:first').text().toLowerCase();
                if (nomepaciente.includes(filtroNome)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });



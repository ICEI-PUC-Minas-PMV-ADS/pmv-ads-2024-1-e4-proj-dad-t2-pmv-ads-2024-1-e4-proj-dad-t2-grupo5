<script>

function receitaMedica(atendimentoId) {
    $.ajax({
        url: `https://vivabemapi.vercel.app/receita/atendimento/${atendimentoId}`,
        type: 'GET',
        headers: {
            'x-api-key': '<?php echo addslashes($apiKey); ?>'
        },
        success: function(data) {
            var modalBody = $('#receitaMedicaModal .modal-body');
            modalBody.empty();
            if (data && data.length > 0) {
                var receita = data[0];
                modalBody.append(`<button class="btn btn-primary imprimirReceitaBtn acs" data-receita='${JSON.stringify(receita)}'>Imprimir</button>`);
            } else {
                modalBody.append(`<button class="btn btn-primary acs" onclick="emitirReceita('${atendimentoId}')">Emitir</button>`);
            }
            $('#receitaMedicaModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.log('Erro ao carregar as receitas: ' + error);
        }
    });
}

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('imprimirReceitaBtn')) {
        var receita = JSON.parse(event.target.getAttribute('data-receita'));
        imprimirReceita(receita);
    }
});


function imprimirReceita(receita) {
    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    document.body.appendChild(iframe);

    iframe.onload = function() {
        var doc = iframe.contentDocument || iframe.contentWindow.document;
        var dataInicio = new Date(receita.dataInicio).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
        var dataFim = new Date(receita.dataFim).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });

        var html = `
            <h2>Detalhes da Receita</h2>
            <p><strong>Paciente:</strong> ${receita.atendimentoRef.paciente.nome}</p>
            <p><strong>Médico:</strong> ${receita.atendimentoRef.medicoId.nome}</p>
            <p><strong>Data Início:</strong> ${dataInicio}</p>
            <p><strong>Data Fim:</strong> ${dataFim}</p>
            <h3>Medicamentos:</h3>
            <ul>
                ${receita.medicamentos.map(medic => `<li>${medic.nome} | Quantidade: ${medic.quantidade} | Período: ${medic.periodo}</li>`).join('')}
            </ul>
            <p><strong>Observações:</strong> ${receita.observacoes}</p>
        `;

        doc.open();
        doc.write(html);
        doc.close();

        setTimeout(function() {
            iframe.contentWindow.print();
            document.body.removeChild(iframe);
        }, 500);
    };

    iframe.srcdoc = "about:blank";
}


function visualizarAtendimento(atendimentoId) {
    $.ajax({
        url: `https://vivabemapi.vercel.app/atendimentos/${atendimentoId}`,
        type: 'GET',
        headers: {
            'x-api-key': '<?php echo $apiKey; ?>'
        },
        success: function(data) {
            var atendimento = data[0];

            if (atendimento) { 
                var nomeMedico = atendimento.medico ? atendimento.medico.nome : 'Não informado';
                var crmMedico = atendimento.medico ? atendimento.medico.crm : 'Não informado';
                var nomePaciente = atendimento.paciente ? atendimento.paciente.nome : 'Não informado';
                var sexoPaciente = atendimento.paciente ? atendimento.paciente.sexo : 'Não informado';
                var susPaciente = atendimento.paciente ? atendimento.paciente.sus : 'Não informado';
                var enderecoPaciente = atendimento.paciente ? `${atendimento.paciente.logradouro}, ${atendimento.paciente.numero} <br> ${atendimento.paciente.bairro} <br> ${atendimento.paciente.cidade} / ${atendimento.paciente.estado}` : 'Não informado';

                if ($('#dadosMedico').length) {
                    $('#dadosMedico').html(
                        `<h5>Dados do médico</h5>
                        <p>Nome: ${nomeMedico}</p>
                        <p>CRM: ${crmMedico}</p>`
                    );
                }

                if ($('#dadosPaciente').length) {
                    $('#dadosPaciente').html(
                        `<h5>Dados do paciente</h5>
                        <p>Nome: ${nomePaciente}</p>
                        <p>SUS: ${susPaciente}</p>
                        <p>Sexo: ${sexoPaciente}</p>
                        <p>Endereço: ${enderecoPaciente}</p>`
                    );
                }

                if ($('#descricaoAtendimento').length) {
                    $('#descricaoAtendimento').html(
                        `<h5>Descrição do Atendimento</h5>
                        <p>${atendimento.descricao || 'Não informado'}</p>`
                    );
                }

                $('#visualizarAtendimentoModal').modal('show');
            } else {
                console.log('Nenhum atendimento encontrado para o ID fornecido.');
            }
        },
        error: function(xhr, status, error) {
            console.log('Erro ao carregar detalhes do atendimento: ' + error);
            if ($('#visualizarAtendimentoModal .modal-body').length) {
                $('#visualizarAtendimentoModal .modal-body').html(`<p>Erro ao carregar detalhes do atendimento: ${error}</p>`);
            }
            $('#visualizarAtendimentoModal').modal('show');
        }
    });
}
</script>
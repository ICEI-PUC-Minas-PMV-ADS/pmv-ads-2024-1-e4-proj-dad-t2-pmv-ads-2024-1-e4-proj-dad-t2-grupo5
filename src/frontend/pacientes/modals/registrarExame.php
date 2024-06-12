<div class="modal fade" id="registrarExameModal" tabindex="-1" role="dialog" aria-labelledby="registrarExameModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrarExameModalLabel">Gestão de Exame</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary btn-block" onclick="imprimirSolicitacao()">Imprimir Solicitação</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success btn-block" id="btnAcaoExame" onclick="registrarExameRealizado()">Registrar Exame</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
    function verificarExame(atendimentoId) {
        $.ajax({
            url: `https://vivabemapi.vercel.app/examesRealizados/${atendimentoId}`,
            type: 'GET',
            headers: {
                'x-api-key': '<?php echo addslashes($apiKey); ?>'
            },
            success: function(response) {
                if (response.exists) {
                    $('#btnAcaoExame').text('Imprimir Exame').attr('onclick', 'imprimirExameRealizado()');
                } else {
                    $('#btnAcaoExame').text('Registrar Exame').attr('onclick', 'registrarExameRealizado()');
                }
                $('#registrarExameModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao verificar a existência da realização de exame: ' + error);
                alert('Erro ao verificar a existência de exame.');
            }
        });
    }

    function imprimirExameRealizado() {
        var atendimentoId = $('#registrarExameModal').data('atendimentoId');
        
        $.ajax({
            url: `https://vivabemapi.vercel.app/examesRealizados/detalhes/${atendimentoId}`,
            type: 'GET',
            success: function(data) {
                var conteudoParaImprimir = montarConteudoImpressaoExame(data);
                criarEImprimirIframe(conteudoParaImprimir);
            },
            error: function(xhr, status, error) {
                console.error('Erro ao obter detalhes do exame realizado:', error);
                alert('Erro ao obter detalhes do exame realizado.');
            }
        });
    }

    function montarConteudoImpressaoExame(dados) {
        var html = `
            <html>
            <head>
                <title>Exame Realizado</title>
                <style>
                    body { font-family: Arial, sans-serif; font-size: 14px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                <h1>Detalhes do Exame Realizado</h1>
                <p><strong>Atendimento ID:</strong> ${dados.solicitacaoRef.AtendimentoId}</p>
                <p><strong>Médico:</strong> ${dados.solicitacaoRef.medico.nome} (${dados.solicitacaoRef.medico.crm})</p>
                <p><strong>Paciente:</strong> ${dados.solicitacaoRef.paciente.nome} (SUS: ${dados.solicitacaoRef.paciente.sus})</p>
                <p><strong>Data de Realização:</strong> ${new Date(dados.dataRealizacao).toLocaleDateString()}</p>
                <table>
                    <tr><th>Exame</th><th>Resultado</th><th>Faixa Normal</th></tr>`;

        dados.resultados.forEach(result => {
            html += `<tr>
                        <td>${result.nomeExame}</td>
                        <td>${result.resultado}</td>
                        <td>${result.normalRange}</td>
                    </tr>`;
        });

        html += `</table>
                <p><strong>Observações:</strong> ${dados.observacoes}</p>
            </body>
            </html>`;

        return html;
    }

    function criarEImprimirIframe(conteudo) {
        var iframe = document.createElement('iframe');
        iframe.style.position = 'absolute';
        iframe.style.right = '100%'; // Esconde o iframe
        document.body.appendChild(iframe);

        var doc = iframe.contentDocument || iframe.contentWindow.document;
        doc.open();
        doc.write(conteudo);
        doc.close();

        iframe.onload = function() {
            iframe.contentWindow.print();
            document.body.removeChild(iframe); // Remove o iframe após a impressão
        };
    }

    function imprimirSolicitacao() {
        var atendimentoId = $('#registrarExameModal').data('atendimentoId');
        console.log('Atendimento ID:', atendimentoId);

        // Primeira chamada para obter detalhes do atendimento
        $.ajax({
            url: `https://vivabemapi.vercel.app/atendimentos/${atendimentoId}`,
            type: 'GET',
            success: function(atendimentoDataArray) {
                if (atendimentoDataArray.length > 0) {
                    var atendimentoData = atendimentoDataArray[0]; // Acessando o primeiro elemento
                    console.log('Dados do Atendimento:', atendimentoData);
                    // Segunda chamada para obter detalhes dos exames solicitados
                    $.ajax({
                        url: `https://vivabemapi.vercel.app/solicitacaoExames/atendimento/${atendimentoId}`,
                        type: 'GET',
                        success: function(exameData) {
                            console.log('Dados da Solicitação de Exames:', exameData);
                            var conteudoParaImprimir = montarConteudoImpressao(atendimentoData, exameData);
                            criarEImprimirIframe(conteudoParaImprimir);
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro ao obter dados dos exames para impressão:', error);
                        }
                    });
                } else {
                    console.error('Atendimento não encontrado.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro ao obter dados do atendimento para impressão:', error);
            }
        });
    }

    function montarConteudoImpressao(atendimentoData, exameData) {
        var medico = atendimentoData.medico;
        var paciente = atendimentoData.paciente;

        var html = `
            <html>
            <head>
                <title>Solicitação de Exame</title>
                <style>
                    body { font-family: Arial, sans-serif; font-size: 14px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                <h1>Solicitação de Exame</h1>
                <p><strong>Nome do Médico:</strong> ${medico.nome}</p>
                <p><strong>CRM do Médico:</strong> ${medico.crm}</p>
                <p><strong>Nome do Paciente:</strong> ${paciente.nome}</p>
                <p><strong>Data de Nascimento:</strong> ${new Date(paciente.dataNascimento).toLocaleDateString('pt-BR')}</p>
                <p><strong>Número do SUS:</strong> ${paciente.sus}</p>
                <table>
                    <tr><th>Exame</th><th>Solicitado</th></tr>
        `;

        Object.keys(exameData).forEach(key => {
            if (typeof exameData[key] === 'boolean' && exameData[key]) {
                html += `<tr><td>${formatKey(key)}</td><td>Sim</td></tr>`;
            }
        });

        html += `
                </table>
            </body>
            </html>
        `;
        return html;
    }

    function formatKey(key) {
        return key.replace(/([A-Z])/g, ' $1').trim().replace(/^./, str => str.toUpperCase()); 
    }

    function criarEImprimirIframe(conteudo) {
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none'; 
        document.body.appendChild(iframe);

        iframe.onload = function() {
            var doc = iframe.contentDocument || iframe.contentWindow.document;
            doc.open();
            doc.write(conteudo);
            doc.close();

            setTimeout(function() {
                iframe.contentWindow.print();
                document.body.removeChild(iframe); 
            }, 500);
        };

        iframe.srcdoc = "about:blank"; 
    }

    function registrarExameRealizado() {
        var atendimentoId = $('#registrarExameModal').data('atendimentoId');
        var pacienteId = $('#registrarExameModal').data('pacienteId');
        var medicoId = $('#registrarExameModal').data('medicoId');

        var form = $('#formRegistrarExame');
        form.data('atendimentoId', atendimentoId);
        form.data('pacienteId', pacienteId);
        form.data('medicoId', medicoId);

        $('#modalRegistrarExame').modal('show');
    }

    function abrirGestaoExame(atendimentoId) {
        $('#registrarExameModal').data('atendimentoId', atendimentoId);
        verificarExame(atendimentoId);
    }
</script>


<div class="modal fade" id="modalRegistrarExame" tabindex="-1" role="dialog" aria-labelledby="modalRegistrarExameLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarExameLabel">Registrar Exame Realizado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarExame">
                    <div class="form-group">
                        <label>Data de Realização</label>
                        <input type="date" class="form-control" name="dataRealizacao" required>
                    </div>
                    <div class="form-group">
                        <label>Observações</label>
                        <input type="text" class="form-control" name="observacoes">
                    </div>
                    <div id="resultadosExame">
                        <h5>Resultados</h5>
                        <div class="form-row resultado-exame">
                            <div class="col">
                                <input type="text" class="form-control" name="nomeExame[]" placeholder="Nome do Exame" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="resultado[]" placeholder="Resultado" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="normalRange[]" placeholder="Faixa Normal" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="adicionarResultado()">+</button>
                    <button type="submit" class="btn btn-primary mt-2">Registrar Exame</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function adicionarResultado() {
        const container = document.getElementById('resultadosExame');
        const novoResultado = document.createElement('div');
        novoResultado.className = 'form-row resultado-exame';
        novoResultado.innerHTML = `
            <div class="col">
                <input type="text" class="form-control" name="nomeExame[]" placeholder="Nome do Exame" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="resultado[]" placeholder="Resultado" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="normalRange[]" placeholder="Faixa Normal" required>
            </div>
        `;
        container.appendChild(novoResultado);
    }

    // Função para enviar dados
    document.getElementById('formRegistrarExame').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const atendimentoId = form.data('atendimentoId');
        const pacienteId = form.data('pacienteId');
        const medicoId = form.data('medicoId');

        const formData = new FormData(this);
        const data = {
            solicitacaoRef: {
                AtendimentoId: atendimentoId,
                medico: medicoId,
                paciente: pacienteId
            },
            resultados: [],
            dataRealizacao: formData.get('dataRealizacao'),
            observacoes: formData.get('observacoes')
        };

        formData.getAll('nomeExame[]').forEach((nomeExame, index) => {
            data.resultados.push({
                nomeExame: nomeExame,
                resultado: formData.getAll('resultado[]')[index],
                normalRange: formData.getAll('normalRange[]')[index]
            });
        });

        fetch('https://vivabemapi.vercel.app/examesRealizados/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            $('#modalRegistrarExame').modal('hide');
            location.reload();
        })
        .catch(error => {
            console.error('Erro ao registrar exame:', error);
            alert('Erro ao registrar exame: ' + error.message);
        });
    });
</script>



    <?php
        include '../partials/header.php';
    ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Receitas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<main>
    
    <div class="container mt-4">
        
        <h2>Receita</h2>
        <!-- Filtro de texto -->
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#adicionarMedicamentoModal">
            Adicionar Receita
        </button>
        <div class="form-group">
            <label for="filtroTexto">Filtrar por texto:</label>
            <input type="text" class="form-control" id="filtroTexto">
        </div>
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
                <!-- Os dados da tabela serão inseridos aqui via JavaScript -->
            </tbody>
        </table>
    </div>
</main>

<script>
    // Evento click para o botão imprimir
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('imprimirReceitaBtn')) {
            var receita = JSON.parse(event.target.getAttribute('data-receita'));
    
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);
    
            // Carrega o conteúdo do iframe antes da impressão
            iframe.onload = function() {
                var dataInicio = new Date(receita.dataInicio);
                var dataFim = new Date(receita.dataFim);
                var options = { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' };
    
                var html = `
                    <h2>Detalhes da Receita</h2>
                    <p><strong>Paciente:</strong> ${receita.atendimentoRef.paciente.nome}</p>
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
    
                // Espera antes da impressão
                setTimeout(function() {
                    iframe.contentWindow.print();
                    // Remove o iframe após a impressão
                    setTimeout(function() {
                        document.body.removeChild(iframe);
                    }, 2000);
                }, 1000); 
            };
    
            // Define o URL do iframe após a função onload
            iframe.src = 'modelo_impressao.html';
        }
    });
    
    
    document.addEventListener('DOMContentLoaded', () => {
        // Função para carregar os dados da API e popular a tabela
        const carregarDados = async () => {
            try {
                const response = await fetch('http://localhost:3001/receita');
                const data = await response.json();

                if (data && data.length > 0) {
                    const tabelaEstoque = document.getElementById('tabelaEstoque');

                    data.forEach(receitaAtendimento => {
                        const tr = document.createElement('tr');

                        tr.innerHTML = `
                            <td>${receitaAtendimento.atendimentoRef.paciente.nome}</td>
                            <td>${new Date(receitaAtendimento.dataInicio).toLocaleDateString('pt-BR')}</td>
                            <td>${new Date(receitaAtendimento.dataFim).toLocaleDateString('pt-BR')}</td>
                            <td>
                                <button type="button" class="btn btn-primary editarReceitaBtn">
                                    Editar
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary imprimirReceitaBtn" data-receita='${JSON.stringify(receitaAtendimento)}'>
                                    Imprimir Receita
                                </button>
                            </td>
                        `;

                        tabelaEstoque.appendChild(tr);
                    });
                } else {
                    const tabelaEstoque = document.getElementById('tabelaEstoque');
                    tabelaEstoque.innerHTML = `
                        <tr>
                            <td colspan="5">Nenhum medicamento encontrado.</td>
                        </tr>
                    `;
                }
            } catch (error) {
                console.error('Erro ao carregar os dados:', error);
            }
        };

        // Chamar a função para carregar os dados
        carregarDados();
    });



</script>






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


</body>
</html>

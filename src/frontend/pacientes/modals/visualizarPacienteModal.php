    <!-- Modal de Visualização de Paciente -->
<div class="modal fade" id="visualizarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="visualizarPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visualizarPacienteModalLabel">Detalhes do Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-3">Nome:</dt>
                    <dd class="col-sm-9" id="visualizarNome"></dd>

                    <dt class="col-sm-3" id="idLabel" style="display: none;">Id:</dt>
                    <dd class="col-sm-9" id="id" style="display: none;"></dd>

                    
                    <dt class="col-sm-3">Nome da Mãe:</dt>
                    <dd class="col-sm-9" id="visualizarNomeMae"></dd>

                    <dt class="col-sm-3">Data de Nascimento:</dt>
                    <dd class="col-sm-9" id="visualizarDataNascimento"></dd>

                    <dt class="col-sm-3">Sexo:</dt>
                    <dd class="col-sm-9" id="visualizarSexo"></dd>

                    <dt class="col-sm-3">SUS:</dt>
                    <dd class="col-sm-9" id="visualizarSUS"></dd>

                    <dt class="col-sm-3">PEC:</dt>
                    <dd class="col-sm-9" id="visualizarPEC"></dd>

                    <dt class="col-sm-3">Logradouro:</dt>
                    <dd class="col-sm-9" id="visualizarLogradouro"></dd>

                    <dt class="col-sm-3">Bairro:</dt>
                    <dd class="col-sm-9" id="visualizarBairro"></dd>

                    <dt class="col-sm-3">Número:</dt>
                    <dd class="col-sm-9" id="visualizarNumero"></dd>

                    <dt class="col-sm-3">Cidade:</dt>
                    <dd class="col-sm-9" id="visualizarCidade"></dd>

                    <dt class="col-sm-3">Estado:</dt>
                    <dd class="col-sm-9" id="visualizarEstado"></dd>

                    <dt class="col-sm-3">ACS:</dt>
                    <dd class="col-sm-9" id="visualizarACS"></dd>

                    <dt class="col-sm-3">Alergias:</dt>
                    <dd class="col-sm-9" id="visualizarAlergias"></dd>

                    <dt class="col-sm-3">Comorbidades:</dt>
                    <dd class="col-sm-9" id="visualizarComorbidades"></dd>

                    <dt class="col-sm-3">Telefone:</dt>
                    <dd class="col-sm-9" id="visualizarTelefone"></dd>

                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9" id="visualizarEmail"></dd>

                    <dt class="col-sm-3">Etnia:</dt>
                    <dd class="col-sm-9" id="visualizarEtnia"></dd>

                    <dt class="col-sm-3">Estado Civil:</dt>
                    <dd class="col-sm-9" id="visualizarEstadoCivil"></dd>

                    <dt class="col-sm-3">Nacionalidade:</dt>
                    <dd class="col-sm-9" id="visualizarNacionalidade"></dd>

                    <dt class="col-sm-3">Profissão:</dt>
                    <dd class="col-sm-9" id="visualizarProfissao"></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <a id="btnVisualizarAtendimentos" class="btn btn-primary">Visualizar Atendimentos</a>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Adiciona um evento de clique ao botão "Visualizar Atendimentos"
    document.getElementById('btnVisualizarAtendimentos').addEventListener('click', function () {
        // Obtém o ID do paciente atualmente visualizado
        const pacienteId = document.getElementById('id').textContent;
        // Redireciona para a página de atendimentos com o ID do paciente incluído no URL
        window.location.href = `atendimentos.php?pacienteId=${pacienteId}`;
    });
</script>



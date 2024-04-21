    <!-- Modal de Visualização de Paciente -->
<div class="modal fade" id="visualizarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="visualizarPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visualizarPacienteModalLabel">Dados do Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <style>
                .secao{
                    border: solid 1px; 
                    border-color: #0e0e0e38 !important;
                    margin: 0 15px;
                    padding: 5px 0 0;
                    border-radius: 7px;
                    margin-bottom: 5px;
                }
                #btnVisualizarAtendimentos{
                    text-decoration: none;
                    color: #ffffff;
                }
            </style>
            <div class="modal-body">
                <div class="secao">
                    <dl class="row mb-0">
                        <div class="col-md-4">
                            <dt class="col-12">Nome:</dt>
                            <dd class="col-12" id="visualizarNome"></dd>
                        </div>

                        <div class="col-md-4" style="display: none;">
                            <dt class="col-12" id="idLabel">Id:</dt>
                            <dd class="col-12" id="id"></dd>
                        </div>

                        <div class="col-md-4">
                            <dt class="col-12">Nome da Mãe:</dt>
                            <dd class="col-12" id="visualizarNomeMae"></dd>
                        </div>

                        <div class="col-md-4">
                            <dt class="col-12">Data de Nascimento:</dt>
                            <dd class="col-12" id="visualizarDataNascimento"></dd>
                        </div>
                    </dl>
                

                    <dl class="row  mb-0">
                        <div class="col-md-4">
                            <dt class="col-12">Sexo:</dt>
                            <dd class="col-12" id="visualizarSexo"></dd>
                        </div>

                        <div class="col-md-4">
                            <dt class="col-12">SUS:</dt>
                            <dd class="col-12" id="visualizarSUS"></dd>
                        </div>

                        <div class="col-md-4">
                            <dt class="col-12">PEC:</dt>
                            <dd class="col-12" id="visualizarPEC"></dd>
                        </div>
                    </dl>
                </div>

                <div class="secao">
                    <h3 class="text-center mb-3">Endereço</h3>
                    <dl class="row  mb-0">
                        <div class="col-md-4">
                            <dt class="col-12">CEP:</dt>
                            <dd class="col-12" id="visualizarCEP"></dd>
                        </div>

                        <div class="col-md-4">
                            <dt class="col-12">Número:</dt>
                            <dd class="col-12" id="visualizarNumero"></dd>
                        </div>

                        <div class="col-md-4">
                            <dt class="col-12">Logradouro:</dt>
                            <dd class="col-12" id="visualizarLogradouro"></dd>
                        </div>
                    </dl>

                    <dl class="row  mb-0">
                        <div class="col-md-4">
                            <dt class="col-12">Bairro:</dt>
                            <dd class="col-12" id="visualizarBairro"></dd>
                        </div>

                        <div class="col-md-4">
                            <dt class="col-12">Cidade:</dt>
                            <dd class="col-12" id="visualizarCidade"></dd>
                        </div>

                        <div class="col-md-4">
                            <dt class="col-12">Estado:</dt>
                            <dd class="col-12" id="visualizarEstado"></dd>
                        </div>
                    </dl>
                </div>

                <div class="secao"> 
                    <dl class="row mb-0">
                        <div class="col-md-4">
                            <dt class="col-12">ACS:</dt>
                            <dd class="col-12" id="visualizarACS"></dd>
                        </div>
                        <div class="col-md-4">
                            <dt class="col-12">Alergias:</dt>
                            <dd class="col-12" id="visualizarAlergias"></dd>
                        </div>
                        <div class="col-md-4">
                            <dt class="col-12">Comorbidades:</dt>
                            <dd class="col-12" id="visualizarComorbidades"></dd>
                        </div>
                    </dl>
                </div>

                <div class="secao">
                    <h3 class="text-center mb-3">Contato</h3>
                    <div class="row mb-0">
                        <div class="col-md-4">
                            <dt class="col-12">Telefone:</dt>
                            <dd class="col-12" id="visualizarTelefone"></dd>
                        </div>
                        <div class="col-md-4">
                            <dt class="col-12">Email:</dt>
                            <dd class="col-12" id="visualizarEmail"></dd>
                        </div>
                    </div>
                </div>

                <div class="secao">
                    <h3 class="text-center mb-3">Informações complementares</h3>
                    <div class="row mb-0">
                        <div class="col-md-6">
                            <dt class="col-12">Etnia:</dt>
                            <dd class="col-12" id="visualizarEtnia"></dd>
                        </div>
                        <div class="col-md-6">
                            <dt class="col-12">Estado Civil:</dt>
                            <dd class="col-12" id="visualizarEstadoCivil"></dd>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6">
                            <dt class="col-12">Nacionalidade:</dt>
                            <dd class="col-12" id="visualizarNacionalidade"></dd>
                        </div>
                        <div class="col-md-6">
                            <dt class="col-12">Profissão:</dt>
                            <dd class="col-12" id="visualizarProfissao"></dd>
                        </div>
                    </div>
                </div>
             
            </div>
            <div class="modal-footer">
                <a id="btnVisualizarAtendimentos" class="btn btn-primary">Visualizar Atendimentos</a>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btnVisualizarAtendimentos').addEventListener('click', function () {
        const pacienteId = document.getElementById('id').textContent;
        window.location.href = `atendimentos.php?pacienteId=${pacienteId}`;
    });
</script>



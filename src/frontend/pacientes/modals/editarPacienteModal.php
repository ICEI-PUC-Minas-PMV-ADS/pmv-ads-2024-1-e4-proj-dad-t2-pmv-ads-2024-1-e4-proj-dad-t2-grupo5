<!-- Modal de Edição de paciente -->
<div class="modal fade" id="editarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="editarPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarpacienteModalLabel">Editar Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarPacienteForm" method="POST">
                    <div class="form-group">
                        <label for="pacienteNome">Nome</label>
                        <input type="text" class="form-control" id="pacienteNome" name="nome">
                    </div>
                    <div class="form-group">
                        <label for="pacienteNomeMae">Nome da Mãe</label>
                        <input type="text" class="form-control" id="pacienteNomeMae" name="nome_mae">
                    </div>
                    <div class="form-group">
                        <label for="pacienteDataNascimento">Data de Nascimento</label>
                        <input type="date" class="form-control" id="pacienteDataNascimento" name="data_nascimento">
                    </div>
                    <div class="form-group">
                        <label for="pacienteSexo">Sexo</label>
                        <select class="form-control" id="pacienteSexo" name="sexo" required>
                            <option value="">Selecione o sexo</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pacienteSUS">Número do SUS</label>
                        <input type="text" class="form-control" id="pacienteSUS" name="sus">
                    </div>
                    <div class="form-group">
                        <label for="pacientePEC">Número do PEC</label>
                        <input type="text" class="form-control" id="pacientePEC" name="pec">
                    </div>
                    <div class="form-group">
                        <label for="pacienteLogradouro">Logradouro</label>
                        <input type="text" class="form-control" id="pacienteLogradouro" name="logradouro">
                    </div>
                    <div class="form-group">
                        <label for="pacienteBairro">Bairro</label>
                        <input type="text" class="form-control" id="pacienteBairro" name="bairro">
                    </div>
                    <div class="form-group">
                        <label for="pacienteNumero">Número</label>
                        <input type="text" class="form-control" id="pacienteNumero" name="numero">
                    </div>
                    <div class="form-group">
                        <label for="pacienteCidade">Cidade</label>
                        <input type="text" class="form-control" id="pacienteCidade" name="cidade">
                    </div>
                    <div class="form-group">
                        <label for="pacienteEstado">Estado</label>
                        <input type="text" class="form-control" id="pacienteEstado" name="estado">
                    </div>
                    <div class="form-group">
                        <label for="pacienteACS">ACS</label>
                        <input type="text" class="form-control" id="pacienteACS" name="acs">
                    </div>
                    <div class="form-group">
                        <label for="pacienteAlergias">Alergias</label>
                        <select class="form-control" id="pacienteAlergias" name="alergias">
                            <option value="">Selecione uma alergia</option>
                            <option value="Nenhuma">Nenhuma</option>
                            <option value="Alergia a medicamentos">Alergia a medicamentos</option>
                            <option value="Alergia a alimentos">Alergia a alimentos</option>
                            <!-- Adicione mais opções conforme necessário -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pacienteComorbidades">Comorbidades</label>
                        <select class="form-control" id="pacienteComorbidades" name="comorbidades">
                            <option value="">Selecione uma comorbidade</option>
                            <option value="Nenhuma">Nenhuma</option>
                            <option value="Asma">Asma</option>
                            <option value="Diabetes">Diabetes</option>
                            <option value="Hipertensão">Hipertensão</option>
                            <!-- ... -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pacienteTelefone">Telefone</label>
                        <input type="text" class="form-control" id="pacienteTelefone" name="telefone">
                    </div>
                    <div class="form-group">
                        <label for="pacienteEmail">Email</label>
                        <input type="email" class="form-control" id="pacienteEmail" name="email">
                    </div>
                    <div class="form-group">
                        <label for="pacienteEtnia">Etnia</label>
                        <select class="form-control" id="pacienteEtnia" name="etnia">
                            <option value="">Selecione uma etnia</option>
                            <option value="Parda">Parda</option>
                            <option value="Negro">Negro</option>
                            <option value="Branco">Branco</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pacienteEstadoCivil">Estado civil</label>
                        <select class="form-control" id="pacienteEstadoCivil" name="estado_civil">
                            <option value="">Selecione o estado civil</option>
                            <option value="Solteiro">Solteiro</option>
                            <option value="Casado">Casado</option>
                            <option value="Divorciado">Divorciado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pacienteNacionalidade">Nacionalidade</label>
                        <input type="text" class="form-control" id="pacienteNacionalidade" name="nacionalidade">
                    </div>
                    <div class="form-group">
                        <label for="pacienteProfissao">Profissão</label>
                        <input type="text" class="form-control" id="pacienteProfissao" name="profissao">
                    </div>
                    <!-- Adicione mais campos conforme necessário -->

                    <input type="hidden" id="pacienteId" name="id">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" id="excluirpaciente">Excluir paciente</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>
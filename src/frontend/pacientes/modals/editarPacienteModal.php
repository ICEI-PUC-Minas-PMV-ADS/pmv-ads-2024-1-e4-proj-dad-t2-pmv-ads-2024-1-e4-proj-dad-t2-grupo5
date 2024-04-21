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

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pacienteNome">Nome</label>
                            <input type="text" class="form-control" id="pacienteNome" name="nome">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pacienteNomeMae">Nome da Mãe</label>
                            <input type="text" class="form-control" id="pacienteNomeMae" name="nome_mae">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pacientePEC">Número do PEC</label>
                            <input type="text" class="form-control" id="pacientePEC" name="pec">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pacienteSUS">Número do SUS</label>
                            <input type="text" class="form-control" id="pacienteSUS" name="sus">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group  col-md-4">
                            <label for="pacienteDataNascimento">Data de Nascimento</label>
                            <input type="date" class="form-control" id="pacienteDataNascimento" name="data_nascimento">
                        </div>
                        <div class="form-group  col-md-4">
                            <label for="pacienteSexo">Sexo</label>
                            <select class="form-control" id="pacienteSexo" name="sexo" required>
                                <option value="">Selecione o sexo</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                            </select>
                        </div>
                        <div class="form-group  col-md-4">
                            <label for="pacienteACS">ACS</label>
                            <input type="text" class="form-control" id="pacienteACS" name="acs">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="cepEditar">CEP:</label>
                            <input
                                type="text"
                                class="form-control"
                                id="cepEditar"
                                placeholder="Digite o CEP"
                                name="cep"
                            />
                        </div>
                        <div class="form-group  col-md-2">
                            <label for="pacienteNumero">Número</label>
                            <input type="text" class="form-control" id="pacienteNumero" name="numero">
                        </div>
                        <div class="form-group  col-md-4">
                            <label for="pacienteLogradouro">Logradouro</label>
                            <input type="text" class="form-control" id="pacienteLogradouro" name="logradouro" readonly>
                        </div>
                        <div class="form-group  col-md-4">
                            <label for="pacienteBairro">Bairro</label>
                            <input type="text" class="form-control" id="pacienteBairro" name="bairro" readonly>
                        </div>
                    </div>
                        
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pacienteCidade">Cidade</label>
                            <input type="text" class="form-control" id="pacienteCidade" name="cidade" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pacienteEstado">Estado</label>
                            <input type="text" class="form-control" id="pacienteEstado" name="estado" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pacienteAlergias">Alergias</label>
                            <select class="form-control" id="pacienteAlergias" name="alergias">
                                <option value="">Selecione uma alergia</option>
                                <option value="Nenhuma">Nenhuma</option>
                                <option value="Alergia a medicamentos">Alergia a medicamentos</option>
                                <option value="Alergia a alimentos">Alergia a alimentos</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
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
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pacienteTelefone">Telefone</label>
                            <input type="text" class="form-control" id="pacienteTelefone" name="telefone">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pacienteEmail">Email</label>
                            <input type="email" class="form-control" id="pacienteEmail" name="email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pacienteEtnia">Etnia</label>
                            <select class="form-control" id="pacienteEtnia" name="etnia">
                                <option value="">Selecione uma etnia</option>
                                <option value="Parda">Parda</option>
                                <option value="Negra">Negra</option>
                                <option value="Branca">Branca</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pacienteEstadoCivil">Estado civil</label>
                            <select class="form-control" id="pacienteEstadoCivil" name="estado_civil">
                                <option value="">Selecione o estado civil</option>
                                <option value="Solteiro">Solteiro</option>
                                <option value="Casado">Casado</option>
                                <option value="Divorciado">Divorciado</option>
                                <option value="Viuvo">Viúvo(a)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pacienteNacionalidade">Nacionalidade</label>
                            <input type="text" class="form-control" id="pacienteNacionalidade" name="nacionalidade">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pacienteProfissao">Profissão</label>
                            <input type="text" class="form-control" id="pacienteProfissao" name="profissao">
                        </div>
                    </div>

                    <input type="hidden" id="pacienteId" name="id">

                    <button type="button" class="btn btn-secondary col-md-3" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger col-md-3" id="excluirpaciente">Excluir paciente</button>
                    <button type="submit" class="btn btn-primary col-md-3">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function buscarEnderecoPorCep2() {
        const cep = document
            .getElementById("cepEditar")
            .value.trim()
            .replace("-", "");

        console.log("Buscando CEP:", cep);

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then((response) => {
                console.log("Resposta da API:", response);
                return response.json();
            })
            .then((data) => {
                console.log("Dados do CEP:", data);
                
                // Se rolar algum erro
                if (data.erro) {
                    console.log("CEP não encontrado:", data);
                    // Limpa
                    document.getElementById("pacienteLogradouro").value = "";
                    document.getElementById("pacienteBairro").value = "";
                    document.getElementById("pacienteCidade").value = "";
                    document.getElementById("pacienteEstado").value = "";
                } else {
                    // Preencher
                    console.log("CEP encontrado:", data);
                    document.getElementById("pacienteLogradouro").value = data.logradouro;
                    document.getElementById("pacienteBairro").value = data.bairro;
                    document.getElementById("pacienteCidade").value = data.localidade;
                    document.getElementById("pacienteEstado").value = data.uf;
                }
            })
            .catch((error) => {
                console.error("Erro ao obter dados do CEP:", error);
                alert("Ocorreu um erro ao obter os dados do CEP. Por favor, tente novamente.");
            });
    }

    document.getElementById("cepEditar").addEventListener("blur", function () {
        buscarEnderecoPorCep2();
    });
</script>
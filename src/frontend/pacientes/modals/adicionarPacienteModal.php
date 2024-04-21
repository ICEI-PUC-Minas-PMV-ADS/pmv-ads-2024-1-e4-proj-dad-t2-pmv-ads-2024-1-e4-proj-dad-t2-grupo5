<!-- Modal de Adição de paciente -->
<div class="modal fade" id="adicionarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="adicionarPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adicionarPacienteModalLabel">Adicionar Novo Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="adicionarPacienteForm" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="novopacienteNome">Nome</label>
                            <input type="text" class="form-control" id="novopacienteNome" name="nome" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="novopacienteNomeMae">Nome da Mãe</label>
                            <input type="text" class="form-control" id="novopacienteNomeMae" name="nomeDaMae" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="novopacientePec">Número do PEC</label>
                            <input type="text" class="form-control" id="novopacientePec" name="pec">
                        </div>

                        <div class="form-group   col-md-6">
                            <label for="novopacienteSus">Número do SUS</label>
                            <input type="text" class="form-control" id="novopacienteSus" name="sus">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group  col-md-4">
                            <label for="novopacienteDataNascimento">Data de Nascimento</label>
                            <input type="date" class="form-control" id="novopacienteDataNascimento" name="dataNascimento" required>
                        </div>
                        <div class="form-group   col-md-4">
                            <label for="novopacienteSexo">Sexo</label>
                            <select class="form-control" id="novopacienteSexo" name="sexo" required>
                                <option value="">Selecione o sexo</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="novopacienteACS">ACS</label>
                            <input type="text" class="form-control" id="novopacienteACS" name="acs">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="cepInput">CEP:</label>
                            <input
                                type="text"
                                class="form-control"
                                id="cepInput"
                                placeholder="Digite o CEP"
                                name="cep"
                            />
                        </div>
                        <div class="form-group  col-md-2">
                            <label for="novopacienteNumero">Número</label>
                            <input type="text" class="form-control" id="novopacienteNumero" name="numero">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="novopacienteLogradouro">Logradouro</label>
                            <input type="text" class="form-control" id="novopacienteLogradouro" name="logradouro" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="novopacienteBairro">Bairro</label>
                            <input type="text" class="form-control" id="novopacienteBairro" name="bairro" readonly>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="novopacienteCidade">Cidade</label>
                            <input type="text" class="form-control" id="novopacienteCidade" name="cidade" readonly>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="novopacienteEstado">Estado</label>
                            <input type="text" class="form-control" id="novopacienteEstado" name="estado" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group  col-md-6">
                            <label for="novopacienteAlergias">Alergias</label>
                            <select class="form-control" id="novopacienteAlergias" name="alergias">
                                <option value="">Selecione uma alergia</option>
                                <option value="Nenhuma">Nenhuma</option>
                                <option value="Alergia a medicamentos">Alergia a medicamentos</option>
                                <option value="Alergia a alimentos">Alergia a alimentos</option>
                            </select>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="novopacienteComorbidades">Comorbidades</label>
                            <select class="form-control" id="novopacienteComorbidades" name="comorbidades">
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
                        <div class="form-group   col-md-6">
                            <label for="novopacienteTelefone">Telefone</label>
                            <input type="text" class="form-control" id="novopacienteTelefone" name="telefone">
                        </div>
                        <div class="form-group   col-md-6">
                            <label for="novopacienteEmail">Email</label>
                            <input type="email" class="form-control" id="novopacienteEmail" name="email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="novopacienteEtnia">Etnia</label>
                            <select class="form-control" id="novopacienteEtnia" name="etnia">
                                <option value="">Selecione uma etnia</option>
                                <option value="Parda">Parda</option>
                                <option value="Negra">Negra</option>
                                <option value="Branca">Branca</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="novopacienteEstadoCivil">Estado civil</label>
                            <select class="form-control" id="novopacienteEstadoCivil" name="estadoCivil">
                                <option value="">Selecione o estado civil</option>
                                <option value="Solteiro">Solteiro(a)</option>
                                <option value="Casado">Casado(a)</option>
                                <option value="Divorciado">Divorciado(a)</option>
                                <option value="Viuvo">Viúvo(a)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="novopacienteNacionalidade">Nacionalidade</label>
                            <input type="text" class="form-control" id="novopacienteNacionalidade" name="nacionalidade">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="novopacienteProfissao">Profissão</label>
                            <input type="text" class="form-control" id="novopacienteProfissao" name="profissao">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="novopacienteSenha">Senha</label>
                        <input type="password" class="form-control" id="novopacienteSenha" name="senha">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="adicionarPacienteForm" class="btn btn-primary">Salvar paciente</button>
            </div>
        </div>
    </div>
</div>

<script>
      function buscarEnderecoPorCep() {
        const cep = document
          .getElementById("cepInput")
          .value.trim()
          .replace("-", "");

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then((response) => response.json())
          .then((data) => {
            // Se rolar algum erro
            if (data.erro) {
              // Limpa
              document.getElementById("novopacienteLogradouro").value = "";
              document.getElementById("novopacienteBairro").value = "";
              document.getElementById("novopacienteCidade").value = "";
              document.getElementById("novopacienteEstado").value = "";
            } else {
              // Preencher
              document.getElementById("novopacienteLogradouro").value =
                data.logradouro;
              document.getElementById("novopacienteBairro").value = data.bairro;
              document.getElementById("novopacienteCidade").value =
                data.localidade;
              document.getElementById("novopacienteEstado").value = data.uf;
            }
          })
          .catch((error) => {
            console.error("Erro ao obter dados do CEP:", error);
            alert(
              "Ocorreu um erro ao obter os dados do CEP. Por favor, tente novamente."
            );
          });
      }

      document.getElementById("cepInput").addEventListener("blur", function () {
        buscarEnderecoPorCep();
});
    </script>

<main>
    <div class="container mt-4">
        <h2>Pacientes</h2>

        <div class="form-group">
            <label for="filtroNome">Filtrar por Nome:</label>
            <input type="text" class="form-control" id="filtroNome">
        </div>

        <button type="button" class="btn btn-success  mb-3" data-toggle="modal" data-target="#adicionarPacienteModal">
            Adicionar Paciente
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>SUS</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pacientes)): ?>
                    <?php foreach ($pacientes as $paciente): ?>
                        <tr>
                            <td><?php echo !empty($paciente['nome']) ? htmlspecialchars($paciente['nome']) : 'Não informado'; ?></td>
                            <td><?php echo !empty($paciente['sus']) ? htmlspecialchars($paciente['sus']) : 'Não informado'; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary editarPacienteBtn" 
                                data-toggle="modal" 
                                data-target="#editarPacienteModal" 
                                data-id="<?php echo $paciente['_id']; ?>" 
                                data-nome="<?php echo !empty($paciente['nome']) ? htmlspecialchars($paciente['nome']) : 'Não informado'; ?>" 
                                data-cep="<?php echo !empty($paciente['cep']) ? htmlspecialchars($paciente['cep']) : 'Não informado'; ?>" 
                                data-nome="<?php echo !empty($paciente['nomeDaMae']) ? htmlspecialchars($paciente['nomeDaMae']) : 'Não informado'; ?>" 
                                data-data-nascimento="<?php echo !empty($paciente['dataNascimento']) ? htmlspecialchars(date('d/m/Y', strtotime($paciente['dataNascimento']))) : 'Não informado'; ?>"
                                data-sexo="<?php echo !empty($paciente['sexo']) ? htmlspecialchars($paciente['sexo']) : 'Não informado'; ?>" 
                                data-sus="<?php echo !empty($paciente['sus']) ? htmlspecialchars($paciente['sus']) : 'Não informado'; ?>" 
                                data-pec="<?php echo !empty($paciente['pec']) ? htmlspecialchars($paciente['pec']) : 'Não informado'; ?>" 
                                data-logradouro="<?php echo !empty($paciente['logradouro']) ? htmlspecialchars($paciente['logradouro']) : 'Não informado'; ?>" 
                                data-bairro="<?php echo !empty($paciente['bairro']) ? htmlspecialchars($paciente['bairro']) : 'Não informado'; ?>" 
                                data-numero="<?php echo !empty($paciente['numero']) ? htmlspecialchars($paciente['numero']) : 'Não informado'; ?>" 
                                data-cidade="<?php echo !empty($paciente['cidade']) ? htmlspecialchars($paciente['cidade']) : 'Não informado'; ?>" 
                                data-estado="<?php echo !empty($paciente['estado']) ? htmlspecialchars($paciente['estado']) : 'Não informado'; ?>" 
                                data-acs="<?php echo !empty($paciente['acs']) ? htmlspecialchars($paciente['acs']) : 'Não informado'; ?>" 
                                data-nome-mae="<?php echo !empty($paciente['nomeDaMae']) ? htmlspecialchars($paciente['nomeDaMae']) : 'Não informado'; ?>" 
                                data-alergias="<?php echo !empty($paciente['alergias']) ? htmlspecialchars($paciente['alergias']) : 'Não informado'; ?>" 
                                data-comorbidades="<?php echo !empty($paciente['comorbidades']) ? htmlspecialchars($paciente['comorbidades']) : 'Não informado'; ?>" 
                                data-telefone="<?php echo !empty($paciente['telefone']) ? htmlspecialchars($paciente['telefone']) : 'Não informado'; ?>" 
                                data-email="<?php echo !empty($paciente['email']) ? htmlspecialchars($paciente['email']) : 'Não informado'; ?>" 
                                data-etnia="<?php echo !empty($paciente['etnia']) ? htmlspecialchars($paciente['etnia']) : 'Não informado'; ?>" 
                                data-estado-civil="<?php echo !empty($paciente['estadoCivil']) ? htmlspecialchars($paciente['estadoCivil']) : 'Não informado'; ?>" 
                                data-nacionalidade="<?php echo !empty($paciente['nacionalidade']) ? htmlspecialchars($paciente['nacionalidade']) : 'Não informado'; ?>" 
                                data-profissao="<?php echo !empty($paciente['profissao']) ? htmlspecialchars($paciente['profissao']) : 'Não informado'; ?>">
                                    Editar
                                </button>
                                <button type="button" class="btn btn-info visualizarPacienteBtn" 
                                data-toggle="modal" 
                                data-target="#visualizarPacienteModal" 
                                data-id="<?php echo $paciente['_id']; ?>" 
                                data-nome="<?php echo !empty($paciente['nome']) ? htmlspecialchars($paciente['nome']) : 'Não informado'; ?>" 
                                data-cep="<?php echo !empty($paciente['cep']) ? htmlspecialchars($paciente['cep']) : 'Não informado'; ?>" 
                                data-nome="<?php echo !empty($paciente['nomeDaMae']) ? htmlspecialchars($paciente['nomeDaMae']) : 'Não informado'; ?>"
                                data-data-nascimento="<?php echo !empty($paciente['dataNascimento']) ? htmlspecialchars(date('d/m/Y', strtotime($paciente['dataNascimento']))) : 'Não informado'; ?>"
                                data-sexo="<?php echo !empty($paciente['sexo']) ? htmlspecialchars($paciente['sexo']) : 'Não informado'; ?>" 
                                data-sus="<?php echo !empty($paciente['sus']) ? htmlspecialchars($paciente['sus']) : 'Não informado'; ?>" 
                                data-pec="<?php echo !empty($paciente['pec']) ? htmlspecialchars($paciente['pec']) : 'Não informado'; ?>" 
                                data-logradouro="<?php echo !empty($paciente['logradouro']) ? htmlspecialchars($paciente['logradouro']) : 'Não informado'; ?>" 
                                data-bairro="<?php echo !empty($paciente['bairro']) ? htmlspecialchars($paciente['bairro']) : 'Não informado'; ?>" 
                                data-numero="<?php echo !empty($paciente['numero']) ? htmlspecialchars($paciente['numero']) : 'Não informado'; ?>" 
                                data-cidade="<?php echo !empty($paciente['cidade']) ? htmlspecialchars($paciente['cidade']) : 'Não informado'; ?>" 
                                data-estado="<?php echo !empty($paciente['estado']) ? htmlspecialchars($paciente['estado']) : 'Não informado'; ?>" 
                                data-acs="<?php echo !empty($paciente['acs']) ? htmlspecialchars($paciente['acs']) : 'Não informado'; ?>" 
                                data-nome-mae="<?php echo !empty($paciente['nomeDaMae']) ? htmlspecialchars($paciente['nomeDaMae']) : 'Não informado'; ?>" 
                                data-alergias="<?php echo !empty($paciente['alergias']) ? htmlspecialchars($paciente['alergias']) : 'Não informado'; ?>" 
                                data-comorbidades="<?php echo !empty($paciente['comorbidades']) ? htmlspecialchars($paciente['comorbidades']) : 'Não informado'; ?>" 
                                data-telefone="<?php echo !empty($paciente['telefone']) ? htmlspecialchars($paciente['telefone']) : 'Não informado'; ?>" 
                                data-email="<?php echo !empty($paciente['email']) ? htmlspecialchars($paciente['email']) : 'Não informado'; ?>" 
                                data-etnia="<?php echo !empty($paciente['etnia']) ? htmlspecialchars($paciente['etnia']) : 'Não informado'; ?>" 
                                data-estado-civil="<?php echo !empty($paciente['estadoCivil']) ? htmlspecialchars($paciente['estadoCivil']) : 'Não informado'; ?>" 
                                data-nacionalidade="<?php echo !empty($paciente['nacionalidade']) ? htmlspecialchars($paciente['nacionalidade']) : 'Não informado'; ?>" 
                                data-profissao="<?php echo !empty($paciente['profissao']) ? htmlspecialchars($paciente['profissao']) : 'Não informado'; ?>">
                                    Visualizar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">Nenhum paciente encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>   

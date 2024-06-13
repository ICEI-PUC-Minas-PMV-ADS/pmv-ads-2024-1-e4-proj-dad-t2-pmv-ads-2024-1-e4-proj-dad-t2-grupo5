<?php
include 'partials/header.php';
require './vendor/autoload.php';

// // Inclui o arquivo de funções
// include_once 'funcoes.php';

// // Verifica a autenticação antes de continuar
// verificarAutenticacao($domain);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $domain; ?>/style.css">
</head>
<body>
    <main>
        <div class="container-box">
        <div class="container">
                <form id="loginForm">
                    <div class="boxselect">
                        <div class="box">
                            <select class="form-control" name="setor">
                                <option disabled selected hidden>Setor</option>
                                <option value="Farmacia">Fármacia</option>
                                <option value="Enfermagem">Enfermagem</option>
                                <option value="Medico">Médico</option>
                                <option value="Recepcao">Recepção</option>
                                <option value="Secretaria">Secretaria</option>
                            </select>
                        </div>
                        <div class="box">
                            <input type="text" class="form-control" name="cpf" placeholder="CPF">
                        </div>
                        <div class="box">
                            <input type="password" class="form-control" name="senha" placeholder="Senha">
                        </div>
                        <button type="submit" class="buttonconfirmar">Confirmar</button>
                        <p id="errorMessage"></p>
                    </div>
                </form>
            </div>
        </div>
    </main>

<script>
    document.getElementById('loginForm').addEventListener('submit', async (event) => {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const requestData = Object.fromEntries(formData.entries());
        
        try {
            const response = await fetch('https://vivabemapi.vercel.app/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            });

            if (!response.ok) {
                const errorMessage = await response.json();
                document.getElementById('errorMessage').innerText = errorMessage.error;
            } else {
                const { usuario } = await response.json();
                console.log(usuario);

                const saveResponse = await fetch('salvar_usuario.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ userData: usuario })
                });

                const saveResult = await saveResponse.json();
                
                if (saveResult.success) {
                    switch (usuario.setor) {
                        case "Medico":
                        case "Pediatria":
                        case "Enfermagem":
                            window.location.href = "<?php echo $domain; ?>/pacientes/";
                            break;
                        case "Farmacia":
                            window.location.href = "<?php echo $domain; ?>/estoque/";
                            break;
                        case "Recepcao":
                            window.location.href = "<?php echo $domain; ?>/fila/";
                            break;
                        case "Secretaria":
                            window.location.href = "<?php echo $domain; ?>/secretaria/";
                            break;
                        default:
                            window.location.href = "pagina_padrao.html";
                    }
                } else {
                    document.getElementById('errorMessage').innerText = 'Erro ao salvar o usuário, por favor, tente novamente.';
                }
            }
        } catch (error) {
            console.error('Erro ao realizar o login', error);
            document.getElementById('errorMessage').innerText = 'Erro ao realizar o login, tente novamente mais tarde';
        }
    });
</script>

<?php
    include 'partials/footer.php';
?>
</body>
</html>
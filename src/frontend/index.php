<?php
include 'actions/login.php';
include 'partials/header.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<!-- Adicionando Font Awesome para ícones -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="http://<?php echo $domain; ?>/style.css">
</head>
<body>
<div class="container-box">
    <div class="container">
        <div class="boxselect">
            <form action="" method="post">
                <div class="box">
                    <select class="form-control">
                        <option disabled selected hidden>Setor</option>
                        <option>Farmácia</option>
                        <option>Enfermagem</option>
                        <option>Médicos</option>
                    </select>
                </div>
                <div class="box">
                    <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="box">
                    <input type="password" name="senha" class="form-control" placeholder="Senha">
                </div>
                <input type="submit" name="login" value="Login" class="buttonconfirmar">
                <p></p>
            </form>
        </div>
    </div>
</div>

<?php
    include 'partials/footer.php';
?>
</body>
</html>

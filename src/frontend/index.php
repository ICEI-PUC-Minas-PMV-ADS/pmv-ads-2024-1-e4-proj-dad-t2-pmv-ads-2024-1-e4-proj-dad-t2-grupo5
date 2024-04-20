<?php
include 'partials/header.php';
require './vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Index Genérica</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<!-- Adicionando Font Awesome para ícones -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container-box">
    <div class="container">
        <div class="boxselect">
            <div class="box">
                <select class="form-control">
                    <option disabled selected hidden>Setor</option>
                    <option>Farmácia</option>
                    <option>Enfermagem</option>
                    <option>Médicos</option>
                </select>
            </div>
            <div class="box">
                <input type="text" class="form-control" placeholder="Usuário">
            </div>
            <div class="box">
                <input type="password" class="form-control" placeholder="Senha">
            </div>
            <button class="buttonconfirmar">Confirmar</button>
            <p></p>
        </div>
    </div>
</div>

<?php
    include 'partials/footer.php';
?>
</body>
</html>

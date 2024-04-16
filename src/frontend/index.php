<?php
require './conexao.php';
include 'partials/header.php';
require './vendor/autoload.php';
include 'partials/footer.php';
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
<style>
    body {
        margin: 0;
    }
    h3 {
        text-align: right;
        margin-right: 50px;
        font-size: 15px;
        margin-top: 0;
        margin-bottom: 0;
    }
    h4 {
        text-align: right;
        margin-right: 50px;
        font-size: 13px;
        margin-top: 0;
        margin-bottom: 0;
    }
    .container-box {
        max-width: 300px;
        margin: 100px auto;
        padding: 25px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        background-color: #f9f9f9;
        margin-bottom: 100px;
    }
    .boxselect {
        text-align: center;
    }
    .box {
        margin-bottom: 25px;
    }
    .buttonconfirmar {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: #ffffff;
        background-color: #28a745;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 8px;
    }
    .buttonconfirmar:hover {
        background-color: #218838;
    }
    h2 {
        text-align: center;
        color: #4169E1;
        font-size: 15px;
        font-family: Arial, sans-serif;
    }
</style>
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
</body>
</html>

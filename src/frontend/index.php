<?php

require './conexao.php';

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
<style>
    .buttons-container {
        text-align: center;
    }
    .button {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px;
        font-size: 16px;
        text-decoration: none;
        color: #ffffff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .button:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="buttons-container">
    <h1>Aqui será a tela de login</h1>
    <p>para fins de testes, utilize a navegação no header.</p>
</div>
</body>
</html>


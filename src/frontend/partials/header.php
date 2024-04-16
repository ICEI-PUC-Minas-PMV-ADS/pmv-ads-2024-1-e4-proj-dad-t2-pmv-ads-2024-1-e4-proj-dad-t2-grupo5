<?php
    $domain = $_SERVER['HTTP_HOST'];
?>

<style>
    .navbar-custom {
        background-color: #AF1717; 
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .navbar-nav .nav-link {
        color: white; 
        font-size: 20px;
        font-weight: bold;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="http://<?php echo $domain; ?>/prontuario">
        <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="Logotipo">
        Viva Bem
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="http://<?php echo $domain; ?>/prontuario/frontend/fila/">Fila</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://<?php echo $domain; ?>/prontuario/frontend/estoque/">Estoque</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://<?php echo $domain; ?>/prontuario/frontend/pacientes/">Pacientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://<?php echo $domain; ?>/prontuario/frontend/receitas/">Receitas</a>
            </li>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
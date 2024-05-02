<?php
    $http = $_SERVER['HTTP_HOST'];
    $domain = "http://$http/vivabem/pmv-ads-2024-1-e4-proj-dad-t2-pmv-ads-2024-1-e4-proj-dad-t2-grupo5/src/frontend";

    session_start();
?>

<nav class="navbar navbar-custom navbar-expand-lg">
    <a class="navbar-brand" href="<?php echo $domain; ?>">
        <img src="<?php echo $domain; ?>/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="Logotipo">
        Viva Bem
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['usuario'])): ?>
                <?php $usuario = $_SESSION['usuario']; ?>
                <?php if ($usuario['setor'] === 'Medico'): ?>
                    <!-- Médicos -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo $domain; ?>/pacientes/">Pacientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $domain; ?>/receitas/">Receitas</a></li>
                <?php elseif ($usuario['setor'] === 'Enfermeiro'): ?>
                    <!-- Enfermaria -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo $domain; ?>/estoque/">Estoque</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $domain; ?>/receitas/">Receitas</a></li>
                <?php elseif ($usuario['setor'] === 'Recepcao'): ?>
                    <!-- Recepção -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo $domain; ?>/fila/">Fila</a></li>
            <?php endif; ?>
                    
            <?php else: ?>
                    <li class="nav-item"><a class="nav-link login" href="<?php echo $domain; ?>/login/">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
    $http = $_SERVER['HTTP_HOST'];
    $domain = "http://$http/vivabem/pmv-ads-2024-1-e4-proj-dad-t2-pmv-ads-2024-1-e4-proj-dad-t2-grupo5/src/frontend";

    session_start();

    if (isset($_GET['logout']) && $_GET['logout'] == '1') {
        session_unset();
        session_destroy();
        header("Location: " . $domain);
        exit();
    }

    include_once __DIR__ . '/../funcoes.php';
    
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
            <!-- Dropdown com o nome do usuário -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $usuario['nome']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Perfil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?logout=1">Sair</a>
                    </div>
                </li>
                    
            <?php else: ?>
                    <li class="nav-item"><a class="nav-link login" href="<?php echo $domain; ?>/login/">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>




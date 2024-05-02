<?php
function verificarAutenticacao($domain) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit();
    }
}
?>

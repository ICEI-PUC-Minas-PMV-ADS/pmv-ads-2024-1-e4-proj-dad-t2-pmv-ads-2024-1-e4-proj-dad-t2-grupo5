<?php
include_once 'config.php';

function verificarAutenticacao($domain) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: $domain");
        exit();
    }
}

// verificar médico

// verificar farmácia

// verificar recepção

// verificar secretaria

?>

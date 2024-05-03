<?php
include_once 'config.php';

function verificarAutenticacao($domain) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: $domain");
        exit();
    }
}

// verificar médico
function verificarIsUserMedico($domain) {
    if (isset($_SESSION['usuario'])) {
        $userData = $_SESSION['usuario'];

        if($userData['setor'] != "Medico"){
            header("Location: $domain");
            exit();
        }
    }
}

// verificar farmácia
function verificarIsUserFarmacia($domain) {
    if (isset($_SESSION['usuario'])) {
        $userData = $_SESSION['usuario'];

        if($userData['setor'] != "Farmacia"){
            header("Location: $domain");
            exit();
        }
    }
}

// verificar recepção
function verificarIsUserRecepcao($domain) {
    if (isset($_SESSION['usuario'])) {
        $userData = $_SESSION['usuario'];

        if($userData['setor'] != "Recepcao"){
            header("Location: $domain");
            exit();
        }
    }
}

// verificar pediatria
function verificarIsUserPediatria($domain) {
    if (isset($_SESSION['usuario'])) {
        $userData = $_SESSION['usuario'];

        if($userData['setor'] != "Pediatria"){
            header("Location: $domain");
            exit();
        }
    }
}

//verificar enfermagem
function verificarIsUserEnfermagem($domain) {
    if (isset($_SESSION['usuario'])) {
        $userData = $_SESSION['usuario'];

        if($userData['setor'] != "Enfermagem"){
            header("Location: $domain");
            exit();
        }
    }
}


?>

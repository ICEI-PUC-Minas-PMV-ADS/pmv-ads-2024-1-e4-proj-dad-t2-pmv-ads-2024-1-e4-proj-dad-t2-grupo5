<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userData'])) {
    $userData = json_decode($_POST['userData'], true);

    $_SESSION['usuario'] = $userData;

    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('error' => 'Dados do usuário não recebidos.'));
}

?>

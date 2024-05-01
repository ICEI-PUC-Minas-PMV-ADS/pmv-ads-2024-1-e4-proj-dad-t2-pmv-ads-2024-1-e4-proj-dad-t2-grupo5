<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userData'])) {
    $userData = json_decode($_POST['userData'], true);

    // Salvar apenas os dados do usuário na sessão, sem um array adicional
    $_SESSION['usuario'] = $userData['usuario']; // Aqui estamos acessando diretamente o array 'usuario'

    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('error' => 'Dados do usuário não recebidos.'));
}
?>

<?php
session_start();

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true); // Decodificar como array associativo

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($input['userData'])) {
    $usuario = $input['userData'];
    $_SESSION['usuario'] = $usuario; // Salvar usuário na sessão

    echo json_encode(array('success' => true)); // Simplesmente retorne sucesso
} else {
    echo json_encode(array('error' => 'Dados do usuário não recebidos.')); // Retorne erro se não houver dados
}
?>

<?php
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $codigo = $_POST['codigo'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    $conexao = obterConexao();

    $sql = "INSERT INTO estoque (nome, codigo, preco, quantidade) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssdi", $nome, $codigo, $preco, $quantidade);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_close($conexao);
}
?>

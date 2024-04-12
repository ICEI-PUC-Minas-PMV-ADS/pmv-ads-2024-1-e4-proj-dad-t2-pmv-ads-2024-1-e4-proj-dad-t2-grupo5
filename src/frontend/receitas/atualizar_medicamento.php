<?php
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $codigo = $_POST['codigo'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    $conexao = obterConexao();

    $sql = "UPDATE estoque SET nome=?, codigo=?, preco=?, quantidade=? WHERE id=?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssdii", $nome, $codigo, $preco, $quantidade, $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: estoque.php");
        exit(); 
    } else {
    }

    mysqli_close($conexao);
}
?>

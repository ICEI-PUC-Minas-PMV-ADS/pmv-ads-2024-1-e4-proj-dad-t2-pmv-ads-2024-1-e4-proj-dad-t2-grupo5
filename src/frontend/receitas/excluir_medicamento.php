<?php

include '../conexao.php';

if(isset($_POST['id'])) {
    $conexao = obterConexao();

    $id = $_POST['id'];
    $sql = "DELETE FROM estoque WHERE id = ?";
    
    $stmt = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        header("Location: estoque.php");
        exit(); 
    } else {
        echo "Erro ao excluir o medicamento: " . mysqli_error($conexao);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
} else {
    echo "ID do medicamento não fornecido!";
}
?>

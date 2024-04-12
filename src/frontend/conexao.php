<?php
$domain = $_SERVER['HTTP_HOST'];
// require ("$domain/prontuario/vendor/autoload.php");
require("vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function obterConexao() {
    
    $conexao = new mysqli($_ENV['HOST'], $_ENV['USER'], $_ENV['PASSWORD'], $_ENV['BANCO']);
    $conexao->set_charset("utf8mb4");
    // Verificar a conexão
    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conexao->connect_error);
    }

    return $conexao;
}
?>
<?php
// Inicia a sessão se ainda não estiver iniciada
session_start();

// Destroi a sessão, excluindo todos os dados associados a ela
session_destroy();

// Redireciona para alguma página após excluir a sessão, por exemplo, a página inicial
exit; // Certifica-se de que o script não continua a ser executado após o redirecionamento
?>

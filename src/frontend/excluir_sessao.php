<?php
// Inicia a sessão se ainda não estiver iniciada
session_start();

// Destroi a sessão, excluindo todos os dados associados a ela
session_destroy();
header("Location: " . $domain);
exit();
?>

<?php
session_start();

session_destroy();
header("Location: " . $domain);
exit();
?>

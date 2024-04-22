
<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

if(isset($_POST['email']) || isset($_POST['senha'])){

    $databaseConnection = new MongoDB\Client(
        'mongodb://localhost:27017/testDB'
     );
    
    $usuarioCollection = $databaseConnection->testDB->usuario;
    
    $email = $_POST['email'];
    $password = $_POST['senha'];
    
    $user = $usuarioCollection->findOne(['email' => $email]);
    
    // if ($user && password_verify($password, $user['senha'])) {
    if ($user) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['nome'] = $user['nome'];
        echo "Login successful.";
        header('Location: ../pacientes/index.php');
    } else {
        echo "Invalid email or password.";
    }
}


?>
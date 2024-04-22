
<?php

require_once '../vendor/autoload.php';

$databaseConnection = new MongoDB\Client(
    'mongodb://localhost:27017/testDB'
 );

$usuarioCollection = $databaseConnection->testDB->usuario;

if($usuarioCollection){
    echo "Connection Succeded";
    $insertOneResult = $usuarioCollection->insertOne([
        'nome'=> 'lucas',
        'crm'=> '12345',
        'email'=> 'test@test.com',
        'cpf'=> '12345678910',
        'senha'=> '123456789',
        'setor'=> 'test'
    ]);
    printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());
    var_dump($insertOneResult->getInsertedId());
}
else{
    echo "Failed";
}


?>
<?php

include_once '../negocio/usuario.php';

$ci = $_POST['ci'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];

try{
    Usuario::updateModerador($name, $surname, $ci, $email, $password);
}catch(Exception $e){
    echo $e;
}

?>
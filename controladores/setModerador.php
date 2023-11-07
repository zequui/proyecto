<?php
include_once '../negocio/usuario.php';

$ci = $_POST['ci'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];

Usuario::setMod($name, $surname, $ci, $phone, $email, $password);
?>
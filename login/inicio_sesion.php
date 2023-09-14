<?php
include 'usuario.php';
$email = $_GET['email'];
$contraseña = $_GET['contraseña'];

if  (( htmlspecialchars($email) == "rodrigosaezzeballos@gmail.com") && (htmlspecialchars($contraseña) == "asdasd")) {
    header("location: ../principal/principal.html");
  } else {
    header("location: ../inicio_sesion.html");
  }
?>
<?php
include "../negocio/usuario.php";
session_start();
if(isset($_POST["email"]) && $_POST["contraseña"]) {
    $email = $_POST["email"];
    $contraseña = $_POST["contraseña"];

    $listaUsuarios = usuario::getRepo();
    $_SESSION["inicio exitoso"] = false;

    foreach($listaUsuarios as $usuarios){
        if($email == $usuarios->getCorreo() && $contraseña == $usuarios->getContraseña())  {
            $_SESSION["inicio exitoso"] = true;
            $_SESSION["usuario logeado"] = $usuarios;
        }
    }
    if($_SESSION["inicio exitoso"]){
        header("location: ../principal/principal.html");
    }else{
        header("location: ../login/inicio_sesion.html");
    }
}else{
    header("location: ../login/inicio_sesion.html");
}

?>
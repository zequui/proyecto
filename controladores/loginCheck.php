<?php
include_once "../negocio/usuario.php";
session_start();
$_SESSION["inicio exitoso"] = false;
if(isset($_POST["email"]) && $_POST["contraseña"]) {
    $email = $_POST["email"];
    $contraseña = $_POST["contraseña"];

    $listaUsuarios = usuario::getRepo();
    

    foreach($listaUsuarios as $usuarios){
        if($email == $usuarios->getCorreo() && $contraseña == $usuarios->getContraseña())  {
            $_SESSION["inicio exitoso"] = true;
            $_SESSION["usuario logeado"] = $usuarios;
        }
    }
    if($_SESSION["inicio exitoso"]){
        header("location: ../2_principal/principal.php");
    }else{
        header("location: ../1_login/inicio_sesion.php");
    }
}else{
    header("location: ../1_login/inicio_sesion.php");
}

?>
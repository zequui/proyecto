<?php
include_once "../negocio/usuario.php";
session_start();
$_SESSION["inicio exitoso"] = false;
if(isset($_POST["email"]) && $_POST["contraseña"]) {
    $email = $_POST["email"];
    $contraseña = $_POST["contraseña"];

    $listaUsuarios = usuario::getRepo();
    

    foreach($listaUsuarios as $usuario){
        if($email == $usuario->getCorreo() && $contraseña == $usuario->getContraseña())  {
            $_SESSION["inicio exitoso"] = true;
            $_SESSION["usuario logeado"] = $usuarios;
        }
    }
    
    if($_SESSION["usuario logeado"]->getIsAdmin()){
        
    } else {
        header("location: ../2_principal/principal.php");
    }

    if(!$_SESSION['inicio exitoso']){
        header("location: ../1_login/inicio_sesion.php");
    }
} else {
    header("location: ../1_login/inicio_sesion.php");
}
?>
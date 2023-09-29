<?php
include "../negocio/incidente.php";

session_start();
$fecha = $_POST["fecha"];
$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$estado = 0;
$tipo = (int)$_POST['tipo'];

if(!empty($_FILES['archivo_relevante'])){
    $dir='../recursos/';
    $ext=pathinfo($_FILES['archivo_relevante']['name'], PATHINFO_EXTENSION);
    $_FILES['archivo_relevante']['name'] = 'archivo_relevante'.date('d-m-Y H-i-s', time()).'.'.$ext;
    $name = $_FILES['archivo_relevante']['name'];
    
    $path = $dir.$name;

    if(move_uploaded_file($_FILES['archivo_relevante']['tmp_name'], $path)){
        $file = base64_encode(file_get_contents($path));
    }
}else{
    $file='';
    $ext='';
}


incidente::setIncident($fecha, $titulo, $descripcion, $estado, $tipo, $file, $ext);
$_SESSION["incidente enviado"]=true;
header("location:../registrar incidente/registrar incidente.php");
?>
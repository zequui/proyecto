<?php
include_once "../negocio/incidente.php";
include_once "../negocio/persona.php";
include_once "../negocio/relaciones.php";

session_start();
if(empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['phoneNumber']) || empty($_POST['ci']) || empty($_POST['fecha']) || empty($_POST['titulo']) || empty($_POST['descripcion']) || empty($_POST['tipo'])){
    header("location:../3_registrarIncidente/registrar_incidente.php");
}
$namePersona = $_POST['name'];
$surnamePersona = $_POST['surname'];
$telefonoPersona = $_POST['phoneNumber'];
$ciPersona = $_POST['ci'];

$fecha = $_POST["fecha"];
$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$estado = 0;
$tipo = (int)$_POST['tipo'];

if(!empty($_FILES['archivo_relevante'])){
    $dir='../recursos/';
    $ext=pathinfo($_FILES['archivo_relevante']['name'], PATHINFO_EXTENSION);
    $name = $_FILES['archivo_relevante']['name'];
    
    $path = $dir.$name;

    if(move_uploaded_file($_FILES['archivo_relevante']['tmp_name'], $path)){
        $file = base64_encode(file_get_contents($path));
    }
}else{
    $file='';
    $ext='';
}

Persona::setPersona($ciPersona, $namePersona, $surnamePersona, $telefonoPersona);
incidente::setIncident($fecha, $titulo, $descripcion, $estado, $tipo, $file, $ext);

Persona_Incidente::setPersonaIncidente($ciPersona, 0, $titulo, $descripcion);

unlink($path);
$_SESSION["incidente enviado"]=true;
#'archivo_relevante'.date('d-m-Y H-i-s', time()).
header("location:../3_registrarIncidente/registrar_incidente.php");
?>
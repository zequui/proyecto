<?php
include_once "../negocio/incidente.php";
include_once "../negocio/persona.php";
include_once "../negocio/relaciones.php";

session_start();
if(checkIfEmpty()){
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
}else {
    $_SESSION["incidente enviado"]=false;
}

$_POST = array();
header("location:../3_registrarIncidente/registrar_incidente.php");

function checkIfEmpty(){
    foreach($_POST as $value){
        if(empty($value)) return false;
    }
    return true;
}
?>
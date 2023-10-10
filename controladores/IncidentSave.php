<?php
include_once "../negocio/incidente.php";
include_once "../negocio/persona.php";
include_once "../negocio/relaciones.php";

session_start();
if(checkIfEmpty()){
    $dir='../recursos/';

    $namePersona = $_POST['name'];
    $surnamePersona = $_POST['surname'];
    $telefonoPersona = $_POST['phoneNumber'];
    $ciPersona = $_POST['ci'];

    $fecha = $_POST["fecha"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $estado = 0;
    $tipo = $_POST['tipo'];
  
    $fileNames = [];

    if(!empty($_FILES)){
        $nomArchivos = $_FILES['archivos_relevantes']['name'];
        $nomTempArchivos = $_FILES['archivos_relevantes']['tmp_name'];
        
        for($i = 0; $i<count($nomArchivos); $i++){
            $ext = pathinfo($nomArchivos[$i], PATHINFO_EXTENSION);
            $name = 'archivo_incidente'.$i.'_'.date('d-m-Y_H-i-s', time()).'.'.$ext;
            $pathFile = $dir.$name;

            if(move_uploaded_file($nomTempArchivos[$i], $pathFile)){
                array_push($fileNames, $name);
            }
        }
    }

    Persona::setPersona($ciPersona, $namePersona, $surnamePersona, $telefonoPersona);
    incidente::setIncident($fecha, $titulo, $descripcion, $estado, $tipo, $fileNames);

    Persona_Incidente::setPersonaIncidente($ciPersona, 0, $titulo, $descripcion);

    #unlink($path);
    $_SESSION["incidente enviado"]=true;
    #.
}else {
    $_SESSION["incidente enviado"]=false; 
}
header("location:../3_registrarIncidente/registrar_incidente.php");
$_POST = array();

function checkIfEmpty(){
    foreach($_POST as $value){
        if(empty($value)) return false;
    }
    return true;
}
?>
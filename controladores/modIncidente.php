<?php
include_once '../negocio/incidente.php';
include_once '../negocio/relaciones.php';

$formData = $_POST;

$id_incidente = $formData['id_incidente'];
$titulo = $formData['titulo'];
$descripcion = $formData['descripcion'];
$fecha = $formData['fecha'];
$tipo = $formData['type'];

$fileNames = [];
if(!empty($_FILES)){
    $dir='../recursos/private/';
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

incidente::modIncident($id_incidente, $titulo, $descripcion, $fecha, $tipo, $fileNames)
?>
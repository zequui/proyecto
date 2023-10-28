<?php
include_once '../negocio/actividad.php';
include_once '../negocio/relaciones.php';

$formData = $_POST;

$id_actividad = $formData['id_actividad'];
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
        $name = 'archivo_actividad'.$i.'_'.date('d-m-Y_H-i-s', time()).'.'.$ext;
        $pathFile = $dir.$name;

        if(move_uploaded_file($nomTempArchivos[$i], $pathFile)){
            array_push($fileNames, $name);
        }
    }
}

Actividad::modActividad($id_actividad, $descripcion, $fecha, $tipo, $titulo, $fileNames);

if(!empty($formData['ci_personas'])){
    foreach($formData['ci_personas'] as $cedula){
        Persona_Actividad::setPersonaActividad($cedula, 0, $id_actividad);
    }
}
?>
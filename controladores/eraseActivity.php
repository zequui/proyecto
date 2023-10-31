<?php
include_once '../negocio/actividad.php';
include_once '../negocio/relaciones.php';

$id_actividad = $_POST['id_actividad'];
$id_incidente = $_POST['id_incidente'];


$actividades = Actividad::getRepo($id_incidente);

foreach($actividades as $actividad){
    if($actividad->getId() == $id_actividad){
        eraseFiles($actividad->getFileNames());
        break;
    }
}

#eraseFiles($actividad->getFileNames());
Actividad::eraseActividad($id_actividad);

function eraseFiles($fileNames){
    if(!empty($fileNames)) 
        foreach ($fileNames as $file['name']) {
            unlink('../recursos/private/'.$file);;
        }
}

?>
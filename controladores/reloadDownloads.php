<?php
include_once '../negocio/incidente.php';

$id_incidente = $_REQUEST['id_incidente'];

$incidentes = incidente::getRepo();

foreach($incidentes as $incidente){
    if($incidente->getID() == $id_incidente){
        loadDownloads($incidente);
        break;
    }
}

function loadDownloads($incidente){
    $fileNames = $incidente->getArchivos();
    for($i = 0; $i<count($fileNames); $i++){
        echo '
        <p class="col__p"><a class="download_action" href="../controladores/downloadFile.php?file='.$fileNames[$i][0].'" fileName="'.$fileNames[$i][0].'">Descargar '.$i.'</a></p>
        ';
    }
}
?>
<?php
include_once '../negocio/incidente.php';

function loadFile($incidente){
    $files = glob('../recursos/*');
    if(!empty($files)){
        foreach($files as $file){
            unlink($file);
        }
    }
    $filePath = '../recursos/'.$incidente->getID().'_incidente_'.$incidente->getFecha().'.'.$incidente->getExtension();
    $file = fopen($filePath, 'w');
    fwrite($file, base64_decode($incidente->getArchivo()));
    fclose($file);
    return $filePath;
}
?>
<?php
include_once '../negocio/incidente.php';

$incidentID = $_REQUEST['id_incidente'];
$newEstado = $_REQUEST['new_estado'];

if($newEstado > 0 && $newEstado <= 3){
    incidente::updateEstado($incidentID, $newEstado);
}
?>
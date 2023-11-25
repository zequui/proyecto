<?php
include_once '../negocio/incidente.php';

$incidentID = $_REQUEST['id_incidente'];
$newEstado = $_REQUEST['new_estado'];

print_r($_REQUEST);
if($newEstado > 0 && $newEstado <= 5){
    incidente::updateEstado($incidentID, $newEstado);
}
?>
<?php
include_once '../negocio/relaciones.php';
include_once '../negocio/incidente.php';

$id_incidente = $_POST['id_incidente'];
$MssgRevision = $_POST['mensaje'];

Resuelve::addMessage($id_incidente, $MssgRevision);
incidente::updateEstado($id_incidente, 3);

?>
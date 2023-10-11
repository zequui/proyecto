<?php
include_once '../negocio/incidente.php';

$incidentID = $_REQUEST['id_incidente'];

incidente::updateEstado($incidentID, 1);
?>
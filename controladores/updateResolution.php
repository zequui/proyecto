<?php
include_once '../negocio/relaciones.php';

$id_incidente = $_POST['id_incidente'];
$newDescription = $_POST['descripcion'];
$newType = $_POST['tipo'];

Resuelve::updateResolucion($id_incidente, $newDescription, $newType);
incidente::updateEstado($id_incidente, 5);
?>
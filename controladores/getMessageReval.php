<?php
include '../negocio/relaciones.php';

$id_incidente = $_REQUEST['id_incidente'];

echo Resuelve::getMessage($id_incidente);
?>
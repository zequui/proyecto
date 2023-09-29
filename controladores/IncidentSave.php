<?php
include "../negocio/incidente.php";

$fecha = $_POST["fecha"];
$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$estado = 0;
$tipo = (int)$_POST['tipo'];



incidente::setIncident($fecha, $titulo, $descripcion, $estado, $tipo);

?>
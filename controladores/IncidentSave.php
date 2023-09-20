<?php
include "../negocio/incidente.php";

$fecha = $_POST["fecha"];
$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$estado = $_POST["estado"];
$tipo = $_POST["tipo"];

incidente::setIncident($fecha, $titulo, $descripcion, $estado, $tipo);
?>
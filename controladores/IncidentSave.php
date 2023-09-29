<?php
include "../negocio/incidente.php";

session_start();
$fecha = $_POST["fecha"];
$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$estado = 0;
$tipo = (int)$_POST['tipo'];



incidente::setIncident($fecha, $titulo, $descripcion, $estado, $tipo);
$_SESSION["incidente enviado"]=true;
header("location:../registrar incidente/registrar incidente.php");
?>
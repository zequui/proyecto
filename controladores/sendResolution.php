<?php
include_once '../negocio/usuario.php';
include_once '../negocio/relaciones.php';
include_once '../negocio/incidente.php';

session_start();

$id_incidente = $_REQUEST['id_incidente'];
$descripcion = $_REQUEST['descripcion'];
$tipo = $_REQUEST['tipo'];
$ci_moderador = $_SESSION['usuario logeado']->getCi();

Resuelve::setResolucion($ci_moderador, $id_incidente, $descripcion, $tipo, date('Y-m-d'));
incidente::updateEstado($id_incidente, 2);
?>
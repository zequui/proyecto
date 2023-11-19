<?php
include_once '../negocio/usuario.php';
include_once '../negocio/relaciones.php';
include_once '../negocio/incidente.php';

session_start();

$id_incidente = $_REQUEST['id_incidente'];
$descripcion = $_REQUEST['descripcion'];
$tipo = $_REQUEST['tipo'];
$ci_usuario = $_SESSION['usuario logeado']->getCi();
$instant = $_REQUEST['instant'];

Resuelve::setResolucion($ci_usuario, $id_incidente, $descripcion, $tipo, date('Y-m-d'));

if(!$instant){
    incidente::updateEstado($id_incidente, 2);
}else{
    incidente::updateEstado($id_incidente, 5);
}

?>
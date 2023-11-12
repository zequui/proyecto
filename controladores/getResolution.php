<?php
include_once '../negocio/relaciones.php';

$id_incidente = $_REQUEST['id_incidente'];

$resolucion = Resuelve::getResolucion($id_incidente);

if($_REQUEST['mod'] == 'descripcion'){
    echo $resolucion->getDescripcion();
} elseif($_REQUEST['mod'] == 'tipo') {
    echo $resolucion->getTipo();
}
?>
<?php
include_once '../negocio/persona.php';
include_once "../negocio/relaciones.php";

$id_incidente = $_REQUEST['id_incidente'];

$name = $_REQUEST['name'];
$surname = $_REQUEST['surname'];
$ci = $_REQUEST['ci'];
$phoneNumber = $_REQUEST['number'];

Persona::setPersona($ci, $name, $surname, $phoneNumber);
Persona_Incidente::setPersonaIncidente($ci, 1, $id_incidente);

?>


<?php
include_once '../negocio/persona.php';
include_once "../negocio/relaciones.php";

$formData = $_POST;

$id_incidente = $formData['id_incidente'];
$name = $formData['name'];
$surname = $formData['surname'];
$ci = $formData['ci'];
$phoneNumber = $formData['phoneNumber'];

Persona::setPersona($ci, $name, $surname, $phoneNumber);
Persona_Incidente::setPersonaIncidente($ci, 1, $id_incidente);

?>


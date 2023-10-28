<?php
include_once '../negocio/persona.php';

$formData = $_POST;

$name = $formData['name'];
$surname = $formData['surname'];
$ci = $formData['ci'];
$phoneNumber = $formData['phoneNumber'];

Persona::updatePersona($ci, $name, $surname, $phoneNumber);
?>
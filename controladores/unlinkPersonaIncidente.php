<?php
include_once '../negocio/relaciones.php';

$formData = $_POST;

Persona_Incidente::unLinkPersonaIncidente($formData['ci'], $formData['id_incidente'])

?>
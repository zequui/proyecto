<?php
include_once '../negocio/relaciones.php';

$formData = $_POST;

Persona_Actividad::unLinkPersonaActividad($formData['ci'], $formData['id_actividad'])

?>
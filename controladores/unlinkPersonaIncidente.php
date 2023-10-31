<?php
include_once '../negocio/relaciones.php';
include_once '../controladores/getPersonaIncidente.php';

$formData = $_POST;

$denunciante = getPersonaIncidente_Denunciante($formData['id_incidente']);

if(!($formData['ci'] == $denunciante->getCi())){
    Persona_Incidente::unLinkPersonaIncidente($formData['ci'], $formData['id_incidente']);
}
?>
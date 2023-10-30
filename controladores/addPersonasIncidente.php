<?php
include_once '../negocio/persona.php';
include_once "../negocio/relaciones.php";

$formData = $_POST;



print_r($formData['ci_personas']);
if($formData['mod'] == 0){
    $ci = $formData['ci'];
    $name = $formData['name'];
    $surname = $formData['surname'];
    $phoneNumber = $formData['phoneNumber'];
    Persona::setPersona($ci, $name, $surname, $phoneNumber);

} elseif($formData['mod'] == 1){
    $id_incidente = $formData['id_incidente'];
    if(!empty($formData['ci_personas'])){
        foreach($formData['ci_personas'] as $cedula){
            Persona_Incidente::setPersonaIncidente($cedula, 1, $id_incidente);
        }
    }
}


?>


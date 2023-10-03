<?php
include '../negocio/relaciones.php';

function getPersonaIncidente_Denunciante($id){
    $involucrados = Persona_Incidente::getRepo();
    foreach($involucrados as $PersonaIncidente){
        if($PersonaIncidente->getId() == $id && $PersonaIncidente->getRol() == 0){
            return $PersonaIncidente->getPersona();
        }
    }
}

?>
<?php
include '../negocio/relaciones.php';

function getPersonaIncidente_Denunciante($id){
    $involucrados = Persona_Incidente::getRepo($id);
    foreach($involucrados as $PersonaIncidente){
        if($PersonaIncidente->getRol() == 0){
            return $PersonaIncidente->getPersona();
        }
    }
}

function getPersonasIncidente($id){
    $involucrados = [];
    foreach(Persona_Incidente::getRepo($id) as $PersonaIncidente){
        if($PersonaIncidente->getRol() != 0) array_push($involucrados, $PersonaIncidente->getPersona());
    }
    return $involucrados;
}

?>
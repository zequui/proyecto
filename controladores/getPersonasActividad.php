<?php
    include_once '../negocio/relaciones.php';

    function getPersonasActividad($id){
        $involucrados = [];
        foreach(Persona_actividad::getRepo($id) as $PersonaActividad){
            array_push($involucrados, $PersonaActividad->getPersona());
        }
        return $involucrados;
    }
    
?>


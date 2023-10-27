<?php
include_once '../persistencia/repoRelaciones.php';
include_once '../negocio/incidente.php';
include_once '../negocio/actividad.php';
include_once '../negocio/persona.php';

class Persona_Incidente{
    private $ci;
    private $id;
    private $rol;

    public function __construct($ci, $id, $rol)
    {
        $this->ci=$ci;
        $this->id=$id;
        $this->rol=$rol;
    }
    public function getPersona(){
        foreach(Persona::getRepo() as $persona){
            if($this->ci == $persona->getCi()){
                return $persona;
            }
        }
        
    }
    public function getIncidente(){
        foreach(incidente::getRepo() as $incidente){
            if($this->id == $incidente->getID()){
                return $incidente;
            }
        }
    }
    
    public function getCi() {
        return $this->ci;
    }
    public function getId() {
        return $this->id;
    }
    public function getRol(){
        return $this->rol;
    }

    public static function getRepo($idIncidente){
        $rep_PersonaIncidente = new repo_PersonaIncidente();
        return $rep_PersonaIncidente->getPersonaIncidente($idIncidente);
    }
    public static function setPersonaIncidente($ci, $rol, $idIncidente = false){
        $rep_PersonaIncidente = new repo_PersonaIncidente();
        $rep_PersonaIncidente->setPersonaIncidente($ci, $rol, $idIncidente);
    }
}

class Persona_Actividad{
    private $ci;
    private $id;
    private $rol;

    public function __construct($ci, $id, $rol)
    {
        $this->ci=$ci;
        $this->id=$id;
        $this->rol=$rol;
    }
    public function getPersona(){
        foreach(Persona::getRepo() as $persona){
            if($this->ci == $persona->getCi()){
                return $persona;
            }
        }
    }
    public function getActividad($id_incidente){
        foreach(Actividad::getRepo($id_incidente) as $actividad){
            if($this->id == $actividad->getID()){
                return $actividad;
            }
        }
    }

    public function getCi() {
        return $this->ci;
    }
    public function getId() {
        return $this->id;
    }
    public function getRol(){
        return $this->rol;
    }

    public static function getRepo($idActividad){
        $rep_PersonaActividad = new repo_PersonaActividad();
        return $rep_PersonaActividad->getPersonaActividad($idActividad);
    }
    public static function setPersonaActividad($ci, $rol, $idActividad = false){
        $rep_PersonaActividad = new repo_PersonaActividad();
        $rep_PersonaActividad->setPersonaActividad($ci, $rol, $idActividad);
    }
}
?>
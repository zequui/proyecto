<?php
include_once '../persistencia/repoRelaciones.php';
include_once '../negocio/incidente.php';
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

    public static function getRepo(){
        $rep_PersonaIncidente = new repo_PersonaIncidente();
        return $rep_PersonaIncidente->getPersonaIncidente();
    }
    public static function setPersonaIncidente($ci, $rol, $titulo, $descripcion){
        $rep_PersonaIncidente = new repo_PersonaIncidente();
        $rep_PersonaIncidente->setPersonaIncidente($ci, $rol, $titulo, $descripcion);
    }
}
class Persona_actividad{

}
?>
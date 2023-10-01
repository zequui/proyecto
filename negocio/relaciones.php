<?php
include '../persistencia/repoRelaciones.php';

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
    public function getCI(){
        return $this->ci;
    }
    public function getID(){
        return $this->id;
    }
    public function getRol(){
        return $this->rol;
    }

    public static function setPersonaIncidente($ci, $rol, $titulo, $descripcion){
        $rep_PersonaIncidente = new repo_PersonaIncidente();
        $rep_PersonaIncidente->setPersonaIncidente($ci, $rol, $titulo, $descripcion);
    }
}
class Persona_actividad{

}
?>
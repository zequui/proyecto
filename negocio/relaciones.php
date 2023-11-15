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

        if($idIncidente){
            global $perIncidentExist;
            foreach ($rep_PersonaIncidente->getPersonaIncidente($idIncidente) as $personaIncidente) {
                if($personaIncidente->getCi() == $ci && $personaIncidente->getId() == $idIncidente){
                    $perIncidentExist = true;
                } 
            }
    
            if (!$perIncidentExist) {
                $rep_PersonaIncidente->setPersonaIncidente($ci, $rol, $idIncidente);
            }
        } else {
            $rep_PersonaIncidente->setPersonaIncidente($ci, $rol, $idIncidente);
        }
     
    }

    public static function getDenunciantes(){
        $rep_PersonaIncidente = new repo_PersonaIncidente();
        return $rep_PersonaIncidente->getDenunciantes();
    }
    public static function unLinkPersonaIncidente($ci, $idincidente){
        $rep_PersonaIncidente = new repo_PersonaIncidente();
        $rep_PersonaIncidente->unlinkPersonaIncidente($ci, $idincidente);
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

        if($idActividad){
            global $perActExist;
            foreach ($rep_PersonaActividad->getPersonaActividad($idActividad) as $personaActividad) {
                if($personaActividad->getCi() == $ci && $personaActividad->getId() == $idActividad){
                    $perActExist = true;
                } 
            }
            if (!$perActExist) {
                $rep_PersonaActividad->setPersonaActividad($ci, $rol, $idActividad);
            }
        } else {
            $rep_PersonaActividad->setPersonaActividad($ci, $rol, $idActividad);
        }   
    }

    public static function unLinkPersonaActividad($ci, $idActividad){
        $rep_PersonaActividad = new repo_PersonaActividad();
        $rep_PersonaActividad->unLinkPersonaActividad($ci, $idActividad);
    }
}

class Resuelve{
    private $ci_moderador;
    private $id_incidente;
    private $resolucion;
    private $tipo;
    private $fecha;

    public function __construct($ci_moderador, $id_incidente, $resolucion, $tipo, $fecha) {
        $this->ci_moderador = $ci_moderador;
        $this->id_incidente = $id_incidente;
        $this->resolucion = $resolucion;
        $this->tipo = $tipo;
        $this->fecha = $fecha;
    }

    public function getCiModerador() {
        return $this->ci_moderador;
    }

    public function getIdIncidente() {
        return $this->id_incidente;
    }

    public function getDescripcion() {
        return $this->resolucion;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public static function getAllResoluciones(){
        $rep_resolucion = new repo_Resoluciones();
        return $rep_resolucion->getAllResoluciones();
    }
    public static function getResolucion($id_incidente){
        $rep_resolucion = new repo_Resoluciones();
        return $rep_resolucion->getResolution($id_incidente);
    }

    public static function setResolucion($ci, $id, $resolucion, $tipo, $fecha){
        $rep_resolucion = new repo_Resoluciones();
        $rep_resolucion->setResolution($ci, $id, $resolucion, $tipo, $fecha);
    }
    public static function updateResolucion($id, $resolucion, $tipo){
        $rep_resolucion = new repo_Resoluciones();
        $rep_resolucion->updateResolution($id, $resolucion, $tipo);
    }

    public static function addMessage($id_incidente, $msg){
        $rep_resolucion = new repo_Resoluciones();
        $rep_resolucion->addMessage($id_incidente, $msg);
    }
}
?>
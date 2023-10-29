<?php 
include "../persistencia/repoIncidentes.php";
 class incidente {
    private $id;
    private $fecha;
    private $titulo;
    private $descripcion;
    private $estado;
    private $tipo;
    private $nomArchivos = [];

    public function  __construct($id, $fecha, $titulo, $descripcion, $estado, $tipo, $nomArchivos)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->tipo = $tipo;
        $this->nomArchivos = $nomArchivos;
    }
    
    public function getID() {
        return $this->id;
    }

    public function getFecha() {
        return $this->fecha;
    }
    
    public function getTitulo() {
        return $this->titulo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getArchivos() {
        return $this->nomArchivos;
    }
    
    public static function getRepo() {
        $repIncidentes = new repositorioIncidente();
        return $repIncidentes->getIncidents();
    }

    public static function setIncident($fecha, $titulo, $descripcion, $estado, $tipo, $fileNames) {
        $repIncidentes = new repositorioIncidente();
        $repIncidentes->setIncidents($fecha, $titulo, $descripcion, $estado, $tipo, $fileNames);
    }
    
    public static function updateEstado($idIncidente, $newEstado){
        $repIncidentes = new repositorioIncidente();
        $repIncidentes->changeIncidentState($idIncidente, $newEstado);
    }

    public static function modIncident($id_incidente, $titulo, $descripcion, $fecha, $tipo, $fileNames){
        $repIncidentes = new repositorioIncidente();
        $repIncidentes->modIncidente($id_incidente, $titulo, $descripcion, $fecha, $tipo, $fileNames);
    }
}
?>
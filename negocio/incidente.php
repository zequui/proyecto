<?php 
include "../persistencia/repoIncidentes.php";
 class inicidente {
    private $id;
    private $fecha;
    private $titulo;
    private $descripcion;
    private $estado;
    private $tipo;

    public function  __construct($id, $fecha, $titulo, $descripcion, $estado, $tipo)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->tipo = $tipo;
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

    public static function getRepo() {
        $repIncidentes = new repositorioIncidente();
        return $repIncidentes->getIncidents();
    }

    public static function setIncident($fecha, $titulo, $descripcion, $estado, $tipo) {
        $repIncidentes = new repositorioIncidente();
        $repIncidentes->setIncidents($fecha, $titulo, $descripcion, $estado, $tipo);
    }
    
}
?>
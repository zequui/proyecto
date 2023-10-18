<?php

include '../persistencia/repoActividades.php';
class Actividad{
    public $ID_incidente;
    private $id;
    private $detalle;
    private $fecha;
    private $tipo;
    private $nombre;
    private $nombreArchivos = [];

    public function  __construct($ID_incidente, $id, $detalle, $fecha, $tipo, $nombre, $nombreArchivos)
    {
        $this->ID_incidente = $ID_incidente;
        $this->id = $id;
        $this->detalle = $detalle;
        $this->fecha = $fecha;
        $this->tipo = $tipo;
        $this->nombre = $nombre;
        $this->nombreArchivos = $nombreArchivos;
    }
    
    public function getIdIncidente(){
        return $this->ID_incidente;
    }
    public function getId() {
        return $this->id;
    }
    public function getDetalle()
    {
        return $this->detalle;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getFileNames() {
        return $this->nombreArchivos;
    }

    public static function getRepo()
    {
        $repoActividades = new repositorioActividad();
        return $repoActividades->getActividades();
    }
    public static function setActividad($ID_incidente, $detalle, $fecha, $tipo, $nombre, $fileNames)
    {
        $repoActividades = new repositorioActividad();
        $repoActividades->setActividad($ID_incidente, $detalle, $fecha, $tipo, $nombre, $fileNames);
    }

}
?>
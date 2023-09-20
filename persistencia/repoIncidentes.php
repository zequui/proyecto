<?php
include "conexion.php";

class repositorioIncidente {
    private $PDO;

    public function __construct() {
        $newConnection = new conexion;
        $this->PDO = $newConnection->getConnection();
    }
    public function getIncidents() {
        $incidentes=[];
        $stmt=$this->PDO->query("SELECT * FROM inicidentes");
        
        while($row=$stmt->fetch()) {
            array_push($incidentes, new incidente($row["id"],$row["fecha"],$row["titulo"],$row["descripcion"],$row["estado"],$row["tipo"]));
        }
        return $incidentes;
    }
    public function setIncidents($fecha, $titulo, $descripcion, $estado, $tipo) {
        $stmt=$this->PDO->query("INSERT INTO inicidentes (fecha, titulo, descripcion, estado, tipo) VALUES ('".$fecha.",".$titulo.",".$descripcion.",".$estado.",".$tipo."')");
        $stmt->execute();
    }
}
?>
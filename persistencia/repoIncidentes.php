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
        $stmt=$this->PDO->query("SELECT * FROM incidentes");
        
        while($row=$stmt->fetch()) {
            array_push($incidentes, new incidente($row["id"],$row["fecha"],$row["titulo"],$row["descripcion"],$row["estado"],$row["tipo"],$row["nombreArchivo"], $row["extArchivo"]));
        }
        return $incidentes;
    }
    public function setIncidents($fecha, $titulo, $descripcion, $estado, $tipo, $file, $ext) {
        $stmt=$this->PDO->query("INSERT INTO `incidentes` (`id`, `fecha`, `titulo`, `descripcion`, `estado`, `tipo`,`nombreArchivo`,`extArchivo`) VALUES (NULL, '".$fecha."', '".$titulo."', '".$descripcion."', '".$estado."', '".$tipo."','".$file."','".$ext."');");
    }
}
?>
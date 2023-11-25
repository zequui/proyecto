<?php
include_once "conexion.php";

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
            $nombreArchivos = $this->PDO->query('SELECT nombreArchivo FROM archivosIncidente WHERE id_incidente = '.$row['id'])->fetchAll();
            array_push($incidentes, new incidente($row["id"],$row["fecha"],$row["titulo"],$row["descripcion"],$row["estado"],$row["tipo"], $nombreArchivos));
        }
           
        return $incidentes;
    }

    public function setIncidents($fecha, $titulo, $descripcion, $estado, $tipo, $fileNames) {
        $stmt=$this->PDO->query("INSERT INTO `incidentes` (`id`, `fecha`, `titulo`, `descripcion`, `estado`, `tipo`) VALUES (NULL, '".$fecha."', '".$titulo."', '".$descripcion."', '".$estado."', '".$tipo."');");
        if($fileNames)
        {
            $idIncidente=$this->PDO->query('SELECT id FROM incidentes ORDER BY id DESC')->fetch()[0];
            foreach($fileNames as $name){
                $stmt=$this->PDO->query("INSERT INTO archivosIncidente(id_incidente, nombreArchivo) VALUES ('".$idIncidente."', '".$name."')");
            }
        }

    }

    public function changeIncidentState($idIncidente, $newEstado) {
        $stmt=$this->PDO->query('UPDATE incidentes SET estado = '.$newEstado.' WHERE id = '.$idIncidente);
    }

    public function modIncidente($id_incidente, $titulo, $descripcion, $fecha, $tipo, $fileNames){
        $stmt=$this->PDO->query("UPDATE `incidentes`  SET `titulo` = '".$titulo."', `fecha`='".$fecha."', `tipo`='".$tipo."', `descripcion`='".$descripcion."' WHERE id = ".$id_incidente);
        if($fileNames)
        {
            foreach($fileNames as $name){
                $stmt=$this->PDO->query("INSERT INTO archivosIncidente(id_incidente, nombreArchivo) VALUES ('".$id_incidente."', '".$name."')");
            }
        }
    }

    public function searchIncidentes($data, $filter){
        $coincidencias = [];
        $stmt=$this->PDO->query('SELECT * FROM incidentes WHERE '.$filter.' LIKE "%'.$data.'%" AND estado = 5');

        while($row=$stmt->fetch()) {
            $nombreArchivos = $this->PDO->query('SELECT nombreArchivo FROM archivosIncidente WHERE id_incidente = '.$row['id'])->fetchAll();
            array_push($coincidencias, new incidente($row["id"],$row["fecha"],$row["titulo"],$row["descripcion"],$row["estado"],$row["tipo"], $nombreArchivos));
        }
        return $coincidencias;
    }
}
?>
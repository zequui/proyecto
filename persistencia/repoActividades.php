<?php
include_once 'conexion.php';

class repositorioActividad {
    private $PDO;

    public function __construct() {
        $newConnection = new conexion;
        $this->PDO = $newConnection->getConnection();
    }
    public function getActividades($idIncidente){
        $actividades = [];
        $stmt = $this->PDO->query('SELECT * FROM actividades WHERE ID_incidente = '.$idIncidente);
        while($row=$stmt->fetch()) {
            $nombreArchivos = $this->PDO->query('SELECT nombreArchivo FROM archivosActividad WHERE id_actividad = '.$row['id'])->fetchAll();
            array_push($actividades, new Actividad($row['ID_incidente'],$row["id"],$row["detalle"],$row["fecha"],$row["tipo"],$row["nombre"], $nombreArchivos));
        }
        return $actividades;
    }
    public function setActividad($ID_incidente, $detalle, $fecha, $tipo, $nombre, $fileNames) {
        $stmt=$this->PDO->query("INSERT INTO `actividades` (`ID_incidente`, `id`, `detalle`, `fecha`, `tipo`, `nombre`) VALUES ('".$ID_incidente."', NULL, '".$detalle."', '".$fecha."', '".$tipo."', '".$nombre."');");
        if($fileNames)
        {
            $idActividad=$this->PDO->query('SELECT id FROM actividades ORDER BY id DESC')->fetch()[0];
            foreach($fileNames as $name){
                $stmt=$this->PDO->query("INSERT INTO archivosActividad(id_actividad, nombreArchivo) VALUES ('".$idActividad."', '".$name."')");
            }
        }
    }
    public function modActividad($idActividad, $detalle, $fecha, $tipo, $nombre, $fileNames){
        $stmt=$this->PDO->query("UPDATE `actividades`  SET `detalle` = '".$detalle."', `fecha`='".$fecha."', `tipo`='".$tipo."', `nombre`='".$nombre."' WHERE id = ".$idActividad);
        if($fileNames)
        {
            foreach($fileNames as $name){
                $stmt=$this->PDO->query("INSERT INTO archivosActividad(id_actividad, nombreArchivo) VALUES ('".$idActividad."', '".$name."')");
            }
        }
    }
    public function eraseActividad($idActividad){
        $stmt = $this->PDO->query('DELETE FROM tiene WHERE id = '.$idActividad);
        $stmt = $this->PDO->query('DELETE FROM archivosActividad WHERE id_actividad = '.$idActividad);
        $stmt = $this->PDO->query('DELETE FROM actividades WHERE id = '.$idActividad);
    }
}
?>
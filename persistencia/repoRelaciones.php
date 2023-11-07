<?php
require_once 'conexion.php';

class repo_PersonaIncidente{
    private $PDO;
    public function __construct() {
        $newConnection = new conexion;
        $this->PDO = $newConnection->getConnection();
    }
    public function getPersonaIncidente($id) {
        $involucramientos=[];
        $stmt=$this->PDO->query("SELECT * FROM involucra WHERE id =".$id);
        
        while($row=$stmt->fetch()) {
            array_push($involucramientos, new Persona_Incidente($row["ci"],$row["id"],$row["rol"]));
        }
        return $involucramientos;
    }
    public function getDenunciantes(){
        $denunciantes = [];
        $stmt=$this->PDO->query('SELECT * FROM involucra WHERE rol = 0');
        while($row = $stmt->fetch()){
            array_push($denunciantes, new Persona_Incidente($row["ci"],$row["id"],$row["rol"]));
        }
        return $denunciantes;
    }

    public function setPersonaIncidente($ci, $rol, $idIncidente){
        if($idIncidente){
            $stmt=$this->PDO->query("INSERT IGNORE INTO involucra (ci, id, rol) VALUES ('".$ci."', '".$idIncidente."', '".$rol."');");
        } else {
            $id = $this->PDO->query('SELECT id FROM incidentes ORDER BY id DESC LIMIT 1')->fetch()[0];
            $stmt=$this->PDO->query("INSERT INTO involucra (ci, id, rol) VALUES ('".$ci."', '".$id."', '".$rol."');");
        }
    }
    public function unlinkPersonaIncidente($ci, $idIncidente){
        $stmt=$this->PDO->query("DELETE FROM involucra WHERE ci = ".$ci." AND id = ".$idIncidente);
    }
}

class repo_PersonaActividad{
    private $PDO;
    public function __construct() {
        $newConnection = new conexion;
        $this->PDO = $newConnection->getConnection();
    }
    public function getPersonaActividad($id) {
        $involucramientos=[];
        $stmt=$this->PDO->query("SELECT * FROM tiene WHERE id =".$id);
        
        while($row=$stmt->fetch()) {
            array_push($involucramientos, new Persona_actividad($row["ci"],$row["id"],$row["rol"]));
        }
        return $involucramientos;
    }

    public function setPersonaActividad($ci, $rol, $idActividad){
        if($idActividad){
            $stmt=$this->PDO->query("INSERT IGNORE INTO tiene (ci, id, rol) VALUES ('".$ci."', '".$idActividad."', '".$rol."');");
        } else {
            $id = $this->PDO->query('SELECT id FROM actividades ORDER BY id DESC LIMIT 1')->fetch()[0];
            $stmt=$this->PDO->query("INSERT INTO tiene (ci, id, rol) VALUES ('".$ci."', '".$id."', '".$rol."');");
        }
    }

    public function unlinkPersonaActividad($ci, $idActividad){
        $stmt=$this->PDO->query("DELETE FROM tiene WHERE ci = ".$ci." AND id = ".$idActividad);
    }
}

class repo_Resoluciones{
    private $PDO;

    public function __construct() {
        $newConnection = new conexion;
        $this->PDO = $newConnection->getConnection();
    }

    public function getAllResoluciones(){
        $resoluciones = [];
        $stmt = $this->PDO->query('SELECT * FROM resuelve');
        while($row = $stmt->fetch()){
            array_push($resoluciones, new Resuelve($row['ci'], $row['id'], $row['resolucion'], $row['tipo'], $row['fecha_resolucion']));
        }
    }

    public function getResolution($id_incidente){
        $result = $this->PDO->query('SELECT * FROM resuelve WHERE id = '.$id_incidente)->fetch();
        return new Resuelve($result['ci'], $result['id'], $result['resolucion'], $result['tipo'], $result['fecha_resolucion']);
    }

    public function setResolution($ci, $id, $resolucion, $tipo, $fecha){
        $stmt = $this->PDO->query('INSERT INTO resuelve (ci, id, fecha_resolucion, resolucion, tipo) VALUES ("'.$ci.'", "'.$id.'", "'.$fecha.'", "'.$resolucion.'", "'.$tipo.'")');
    }
}
?>

 
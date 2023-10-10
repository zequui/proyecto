<?php
require_once 'conexion.php';

class repo_PersonaIncidente{
    private $PDO;
    public function __construct() {
        $newConnection = new conexion;
        $this->PDO = $newConnection->getConnection();
    }
    public function getPersonaIncidente() {
        $involucramientos=[];
        $stmt=$this->PDO->query("SELECT * FROM involucra");
        
        while($row=$stmt->fetch()) {
            array_push($involucramientos, new Persona_Incidente($row["ci"],$row["id"],$row["rol"]));
        }
        return $involucramientos;
    }

    public function setPersonaIncidente($ci, $rol, $titulo, $descripcion){
        $id = $this->PDO->query('SELECT id FROM incidentes ORDER BY id DESC LIMIT 1')->fetch()[0];
        $stmt=$this->PDO->query("INSERT INTO involucra (ci, id, rol) VALUES ('".$ci."', '".$id."', '".$rol."');");
    }
}
?>
<?
include "conexion.php";

class repositorioPersonas {
    private $PDO;

    public function __construct() {
        $newConnection = new conexion;
        $this->PDO = $newConnection->getConnection();
    }
    public function getPersonas() {
        $usuarios=[];
        $stmt=$this->PDO->query("SELECT * FROM personas");
        
        while($row=$stmt->fetch()) {
            array_push($usuarios, new persona($row["ci"],$row["nombre"],$row["apellido"],$row["telefono"]));
        }
        return $usuarios;
    }
}


?>
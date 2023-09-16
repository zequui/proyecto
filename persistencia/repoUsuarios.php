<?php
include "conexion.php";

class repositorioUsuario {
    private $PDO;

    public function __construct() {
        $newConnection = new conexion;
        $this->PDO = $newConnection->getConnection();
    }
    public function getUsers() {
        $usuarios=[];
        $stmt=$this->PDO->query("SELECT * FROM usuarios");
        
        while($row=$stmt->fetch()) {
            array_push($usuarios, new usuario($row["ci"],$row["nombre"],$row["apellido"],$row["correo"],$row["contraseña"]));
        }
        return $usuarios;
    }
}


?>
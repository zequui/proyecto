<?php
include_once "conexion.php";

class repositorioUsuario {
    private $PDO;

    public function __construct() {
        $newConnection = new conexion;
        $this->PDO = $newConnection->getConnection();
    }
    public function getUsers() {
        $usuarios=[];
        $stmt=$this->PDO->query("SELECT * FROM usuarios INNER JOIN moderadores ON usuarios.ci = moderadores.ci");
        
        while($row=$stmt->fetch()) {
            array_push($usuarios, new Usuario($row["ci"],$row["nombre"],$row["apellido"],$row["correo"],$row["contraseña"], false));
        }
        
        $stmt=$this->PDO->query("SELECT * FROM usuarios INNER JOIN administradores ON usuarios.ci = administradores.ci");
        
        while($row=$stmt->fetch()) {
            array_push($usuarios, new Usuario($row["ci"],$row["nombre"],$row["apellido"],$row["correo"],$row["contraseña"], true));
        }
        return $usuarios;
    }
}


?>
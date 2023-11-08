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
    public function setModerador($name, $surname, $ci, $email, $password){
        $stmt = $this->PDO->query('INSERT INTO usuarios (ci, nombre, apellido, correo, contraseña) VALUES ("'.$ci.'","'.$name.'","'.$surname.'","'.$email.'","'.$password.'")');
        $stmt = $this->PDO->query('INSERT INTO moderadores (ci) VALUES ("'.$ci.'")');
    }
    public function updateModerador($name, $surname, $ci, $email, $password){
        $stmt = $this->PDO->query('UPDATE usuarios SET nombre = "'.$name.'", apellido = "'.$surname.'", correo = "'.$email.'", contraseña = "'.$password.'" WHERE ci = "'.$ci.'"');
    }

}


?>
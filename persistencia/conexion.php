<?php
class conexion {
    private $user;
    private $password;
    private $baseDeDatos;
    private $puerto;

    public function __construct() {
        $this->user = 'quantum';
        $this->password = 'quantum';
        $this->baseDeDatos = 'bd_ri';
        $this->puerto = 3306;
    } 

    public function getConnection() {
        $dsn ='mysql:host=192.168.1.5:'.$this->puerto.';dbname='.$this->baseDeDatos.';charset=UTF8';
        try{
            $pdo = new PDO($dsn, $this->user, $this->password);
            if($pdo) {
                $this->debug_to_console("Connected to the $this->baseDeDatos database successfully!");
                syslog(LOG_INFO, 'Se establecio la conexión');
                return $pdo;
            }
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function debug_to_console($data) {
        $output = $data;
        if(is_array($output)) {
            $output = implode(',', $output);
            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        }
    }
}
?>
<?php
include "../persistencia/repoUsuarios.php";
    class Usuario {
        private $ci;
        private $nombre;
        private $apellido;
        private $correo;
        private $contraseña;
        private $isAdmin;

        public function  __construct($ci, $nombre, $apellido, $correo, $contraseña, $tipo)
        {
            $this->ci = $ci;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->correo = $correo;
            $this->contraseña = $contraseña;
            $this->isAdmin = $tipo;
        }
        
        public function getCi() {
            return $this->ci;
        }

        public function getNombre() {
            return $this->nombre;
        }
        
        public function getApellido() {
            return $this->apellido;
        }

        public function getCorreo() {
            return $this->correo;
        }

        public function getContraseña() {
            return $this->contraseña;
        }

        public function getIsAdmin() {
            return $this->isAdmin;
        }

        public static function getRepo() {
            $repUsarios = new repositorioUsuario();
            return $repUsarios->getUsers();
        }
        public static function setMod($name, $surname, $ci, $email, $password){
            $repUsarios = new repositorioUsuario();
            $repUsarios->setModerador($name, $surname, $ci, $email, $password);
        }
        public static function updateModerador($name, $surname, $ci, $email, $password){
            $repUsarios = new repositorioUsuario();
            $repUsarios->updateModerador($name, $surname, $ci, $email, $password);
        }
        public static function deleteMod($ci){
            $repUsarios = new repositorioUsuario();
            $repUsarios->deleteModerador($ci);
        }
    }
?>
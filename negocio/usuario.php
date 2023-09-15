<?php
include "../persistencia/repoUsuarios.php";
    class usuario {
        private $ci;
        private $nombre;
        private $apellido;
        private $correo;
        private $contraseña;

        public function  __construct($ci, $nombre, $apellido, $correo, $contraseña)
        {
            $this->ci = $ci;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->correo = $correo;
            $this->contraseña = $contraseña;
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

        public static function getRepo() {
            $repUsarios = new repositorioUsuario();
            return $repUsarios->getUsers();
        }
    }
?>
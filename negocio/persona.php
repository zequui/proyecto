<?php

    include '../persistencia/repoPersonas.php';
    class Persona{
        private $ci;
        private $nombre;
        private $apellido;
        private $telefono;

        public function  __construct($ci, $nombre, $apellido, $telefono)
        {
            $this->ci = $ci;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->telefono = $telefono;
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

        public function getTelefono() {
            return $this->telefono;
        }

        public static function getRepo() {
            $repPersonas = new repositorioPersonas();
            return $repPersonas->getPersonas();
        }
    }
?>
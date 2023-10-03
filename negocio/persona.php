<?php

    include '../persistencia/repoPersonas.php';
    class Persona{
        private $ci;
        private $nombre;
        private $apellido;
        private $telefono;
        private $incidentsID;

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
        public function getIncidentsID() {
            return $this->incidentsID;
        }
        public function setIncidentsID($IDs) {
            $this->incidentsID = $IDs;
        }

        public static function getRepo() {
            $repPersonas = new repositorioPersonas();
            return $repPersonas->getPersonas();
        }
        public static function setPersona($ci, $name, $surname, $phone){
            $repPersonas = new repositorioPersonas();
            echo "hola";
            $listCI = [];
            foreach ($repPersonas as $persona) {
                array_push($listCI, $persona->getCi());   
                echo $persona->getCi(); 
            }
            echo '----------'.$ci;

            if (!in_array($ci, $listCI)) {
                $repPersonas->setPersonas($ci, $name, $surname, $phone);
            }

        }
    }

?>
<?php
    class Usuario {
        private $email;
        private $contraseña;

        public function  __construct($email, $contraseña)
        {
            $this->email = $email;
            $this->contraseña = $contraseña;
        }
        
        public function getEmail() {
            return $this->email;
        }

        public function getContraseña() {
            return $this->contraseña;
        }
    }
?>
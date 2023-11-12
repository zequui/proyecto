<?php
include_once '../negocio/usuario.php';

$ci_moderador = $_POST['ci'];

Usuario::deleteMod($ci_moderador);
?>
<?php
session_start();

$_SESSION = array();
session_destroy();

header('location: ../0_inicio/index.html');
?>
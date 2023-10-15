<?php

$fileName = basename($_GET['file']);
$filePath = '../recursos/private/'.$fileName;

header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/".pathinfo($filePath, PATHINFO_EXTENSION));
header("Content-length: " . filesize($filePath));
header("Content-Transfer-Encoding: binary");

readfile($filePath);
?>
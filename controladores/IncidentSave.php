<?php
include_once "../negocio/incidente.php";
include_once "../negocio/persona.php";
include_once "../negocio/relaciones.php";

session_start();
if(checkIfEmpty() && checkCI($_POST['ci'])){
   
    $namePersona = $_POST['name'];
    $surnamePersona = $_POST['surname'];
    $telefonoPersona = $_POST['phoneNumber'];
    $ciPersona = $_POST['ci'];

    $fecha = $_POST["fecha"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $estado = 0;
    $tipo = $_POST['tipo'];
  
    $fileNames = [];

    if(!empty($_FILES)){
        $dir='../recursos/private/';
        $nomArchivos = $_FILES['archivos_relevantes']['name'];
        $nomTempArchivos = $_FILES['archivos_relevantes']['tmp_name'];
        
        for($i = 0; $i<count($nomArchivos); $i++){
            $ext = pathinfo($nomArchivos[$i], PATHINFO_EXTENSION);
            $name = 'archivo_incidente'.$i.'_'.date('d-m-Y_H-i-s', time()).'.'.$ext;
            $pathFile = $dir.$name;

            if(move_uploaded_file($nomTempArchivos[$i], $pathFile)){
                array_push($fileNames, $name);
            }
        }
    }

    Persona::setPersona($ciPersona, $namePersona, $surnamePersona, $telefonoPersona);
    incidente::setIncident($fecha, $titulo, $descripcion, $estado, $tipo, $fileNames);

    Persona_Incidente::setPersonaIncidente($ciPersona, 0);

    #unlink($path);
    $_SESSION["incidente enviado"]=true;
    #.
}else {
    $_SESSION["incidente enviado"]=false; 
}
header("location:../3_registrarIncidente/registrar_incidente.php");
$_POST = array();

function checkIfEmpty(){
    foreach($_POST as $value){
        if(empty($value)) return false;
    }
    return true;
}

function checkCI($ci) {
    if ($ci == 0 || strlen($ci) !== 8) return false;
    $inputValues = str_split($ci, 1);
    $nums = array_map('intval', $inputValues);
    $lastNum = array_pop($nums);
    $result =
      2 * $nums[0] +
      9 * $nums[1] +
      8 * $nums[2] +
      7 * $nums[3] +
      6 * $nums[4] +
      3 * $nums[5] +
      4 * $nums[6];
    $result %= 10;
    $result = (10 - $result) % 10;
  
    if($result == $lastNum) return true ;
    return false;
  };
?>
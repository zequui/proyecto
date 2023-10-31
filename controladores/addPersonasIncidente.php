<?php
include_once '../negocio/persona.php';
include_once "../negocio/relaciones.php";

$formData = $_POST;

if($formData['mod'] == 0){
    $ci = $formData['ci'];
    $name = $formData['name'];
    $surname = $formData['surname'];
    $phoneNumber = $formData['phoneNumber'];
    if(checkCI($ci)){
        Persona::setPersona($ci, $name, $surname, $phoneNumber);
    }
} elseif($formData['mod'] == 1){
    $id_incidente = $formData['id_incidente'];
    if(!empty($formData['ci_personas'])){
        foreach($formData['ci_personas'] as $cedula){
            Persona_Incidente::setPersonaIncidente($cedula, 1, $id_incidente);
        }
    }
}

function checkCI($ci) {
    if ($ci == 0 || count($ci) !== 8) return false;
    $inputValues = explode('', $ci);
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


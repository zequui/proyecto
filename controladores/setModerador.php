<?php
include_once '../negocio/usuario.php';

$ci = $_POST['ci'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];

if(checkCI($ci)){
    Usuario::setMod($name, $surname, $ci, $email, $password);
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
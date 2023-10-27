<?php

$privateFilePath = '../recursos/private/'.$_REQUEST['fileName'];
$publicFilePath = '../recursos/public/'.$_REQUEST['fileName'];

$fileExt = pathinfo($_REQUEST['fileName'], PATHINFO_EXTENSION);

copy($privateFilePath, $publicFilePath);

if(in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
    echo '<img src="'.$publicFilePath.'" class="imgContainer__imgPreview--hidden" id="imgContainer__imgPreview" >';
} else {
    echo '<i class="fa-regular fa-file fa-2xl imgContainer__imgPreview--hidden" id="imgContainer__imgPreview" ></i>';
}
?>
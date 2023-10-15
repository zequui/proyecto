<?php
    $files = glob('../recursos/public/*');
    if(!empty($files)){
        foreach($files as $file){
            unlink($file);
        }
    }

    echo '';
?>
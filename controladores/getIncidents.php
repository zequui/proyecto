<?php
include '../negocio/incidente.php';

function getNewIncidents(){
    $allIncidents = incidente::getIncidents();
    if(empty($allIncidents)){
        return [];
    }
    $filteredIncidents = array_filter($allIncidents, function($incident){
        if($incident->getEstado() == 0){
            return true;
        } else {
            return false;
        }
    });
    return $filteredIncidents;  
}
?>
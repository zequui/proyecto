<?php
include_once '../negocio/incidente.php';
include_once '../controladores/getPersonaIncidente.php';

$allIncidents = incidente::getRepo();
if(empty($allIncidents)){
    return [];
}
$filtro = $_REQUEST['filter'];

$allIncidents = array_reverse($allIncidents);
$filteredIncidents = array_filter($allIncidents, function($incident){
    if($incident->getEstado() == $_REQUEST['filter']){
        return true;
    } else {
        return false;
    }
});

if($filtro == 0){
    foreach($filteredIncidents as $incident){
        $denunciante = getPersonaIncidente_Denunciante($incident->getID());
        $archivos = $incident->getArchivos();
        echo '
        <div class="emergent__incident" id="'.$incident->getID().'">
            <div class="incident__title">
                <p class="title__name">'.$incident->getTitulo().'</p>
                <div class="title__container">
                    <button class="container__button"><i class="fa-solid fa-x fa-xl"></i></i></button>
                    <button class="container__button startIncident_btn"><i class="fa-solid fa-play fa-xl"></i></button>
                    <button class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl"></i></button>
                </div>
            </div>
            <div class="inicident__information incident__information-hidden">
                <div class="information__col ">
                    <label>Descripcion</label>
                    <p class="col__p information_description">'.$incident->getDescripcion().'</p>
                </div>
                <div class="information__col">
                    <label>Fecha</label>
                    <p class="col__p">'.$incident->getFecha().'</p>
                    <div></div>
                    <label>Tipo</label>
                    <p class="col__p">'.$incident->getTipo().'</p>';
                    
                if(!empty($archivos)){
                    echo ' <label>Archivos relevantes</label>';
                    for($i = 0; $i<count($archivos); $i++){
                        echo '<div class="col_downloads">
                        <p class="col__p"><a href="../recursos/'.$archivos[$i][0].'" download="">Descargar '.$i.'</a></p>
                        </div>';
                    }
                }
                
                echo '</div>
                <div class="information__col">
                    <label>Nombre y Apellido</label>
                    <p class="col__p">'.$denunciante->getNombre().' '.$denunciante->getApellido().'</p>
    
                    <label>Cedula</label>
                    <p class="col__p">'.$denunciante->getCi().'</p>
                    
                    <label>Telefono</label>
                    <p class="col__p">'.$denunciante->getTelefono().'</p>
                </div>
            </div>
        </div>
    ';
    }
}
?>
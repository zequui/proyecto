<?php
include_once '../negocio/incidente.php';
include_once '../negocio/actividad.php';
include_once '../controladores/getPersonaIncidente.php';
include_once '../controladores/getPersonasActividad.php';

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
        <div class="emergent__incident" id="incident_'.$incident->getID().'">
            <div class="incident__title">
                <p class="title__name">'.$incident->getTitulo().'</p>
                <div class="title__container">
                    <button class="container__button reject-incident"><i class="fa-solid fa-x fa-xl"></i></i></button>
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
                    echo ' <label>Archivos relevantes</label>
                    <div class="col_downloads">';
                    for($i = 0; $i<count($archivos); $i++){
                        echo '
                        <p class="col__p"><a class="download_action" href="../controladores/downloadFile.php?file='.$archivos[$i][0].'" fileName="'.$archivos[$i][0].'">Descargar '.$i.'</a></p>
                        ';
                    }
                    echo '</div>';
                }
                
                echo '
                </div>
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
}elseif($filtro == 1){
    foreach($filteredIncidents as $incident){
        $denunciante = getPersonaIncidente_Denunciante($incident->getID());
        $involucrados = getPersonasIncidente($incident->getId());

        $archivosIncidente = $incident->getArchivos();
        
        $actividades = Actividad::getRepo($incident->getID());
        
        echo '
                <div class="emergent__incident" id="incident_'.$incident->getID().'">
                    <div class="incident__title">
                        <p class="title__name">'.$incident->getTitulo().'</p>
                            <div id="incident__container">
                                <button class="container__button"><i class="fa-solid fa-rectangle-xmark fa-xl"></i></button>
                                <button class="container__button addInvolucradoIncidente"><i class="fa-solid fa-user-plus fa-lg"></i></button>
                                <button class="container__button edit_incident"><i class="fa-solid fa-pen-to-square fa-xl"></i></button>
                                <button class="container__button addActivity"><i class="fa-solid fa-plus fa-2xl"></i></button>
                                <button class="container__button"><i class="fa-solid fa-check fa-2xl"></i></button>
                                <button class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl"></i></button>
                            </div>
                    </div>
                    <div class="inicident__information--2 incident__information-hidden">
                        <div class="information__container">
                            <div class="information__col--2">
                                <label>Descripcion</label>
                                <p class="col__p">'.$incident->getDescripcion().'</p>
                            </div>
                            <div class="information__col--2">
                                <label>Fecha</label>
                                <p class="col__p">'.$incident->getFecha().'</p>
                                <div></div>
                                <label>Tipo</label>
                                <p class="col__p">'.$incident->getTipo().'</p>
                                ';
                                if(!empty($archivosIncidente)){
                                    echo '<label>Archivo a descargar</label>
                                    <div class="col_downloads">';
                                    for($i = 0; $i<count($archivosIncidente); $i++){
                                        echo '
                                        <p class="col__p"><a class="download_action" href="../controladores/downloadFile.php?file='.$archivosIncidente[$i][0].'" fileName="'.$archivosIncidente[$i][0].'">Descargar '.$i.'</a></p>
                                        ';
                                    }
                                    echo '</div>';
                                }
                            echo '
                            </div>
                            <div class="information__col--2">
                                <label>Nombre y Apellido</label>
                                <p class="col__p">'.$denunciante->getNombre().' '.$denunciante->getApellido().'</p>

                                <label>Cedula</label>
                                <p class="col__p">'.$denunciante->getCi().'</p>
                                
                                <label>Telefono</label>
                                <p class="col__p">'.$denunciante->getTelefono().'</p>
                            </div>
                        </div>
                        <div class="activity--container" id="activity--container_'.$incident->getId().'">
                        ';
                        if(!empty($actividades)){
                        echo '
                       
                        <div class="information__title--activity">
                            <p class="title__name">Actividades</p><hr class="title__hr">
                        </div>';
                        foreach($actividades as $actividad){
                            $archivosActividad = $actividad->getFileNames();
                            $personasInvolucradas = getPersonasActividad($actividad->getId());
                            echo '
                            <div class="information__activity--title" id="activity_'.$actividad->getId().'">
                            <p class="title__name--2">'.$actividad->getNombre().'</p>
                            <div class="title__container">
                                <button class="container__button--2"><i class="fa-solid fa-xmark fa-xl"></i></button>
                                <button class="container__button--2 edit_activity"><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                                <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
                            </div>
                        </div>
                        <div class="activity__information--3 incident__information-hidden">
                            <div class="information__container--2">
                                <div class="information__col--3">
                                    <label>Descripcion</label>
                                    <p class="col__p">'.$actividad->getDetalle().'</p>
                                </div>
                                <div class="information__col--3">
                                    <label>Fecha</label>
                                    <p class="col__p">'.$actividad->getFecha().'</p>
                                    <label>Tipo</label>
                                    <p class="col__p">'.$actividad->getTipo().'</p>';
                                    if(!empty($archivosActividad)){
                                        echo ' <label>Archivos a descargar</label>
                                        <div class="col_downloads">';
                                        for($i = 0; $i<count($archivosActividad); $i++){
                                            echo '
                                            <p class="col__p"><a class="download_action" href="../controladores/downloadFile.php?file='.$archivosActividad[$i][0].'" fileName="'.$archivosActividad[$i][0].'">Descargar '.$i.'</a></p>
                                            ';
                                        }
                                        echo '</div>';
                                    }
                                echo '
                                </div>
                                </div>
                                ';
                                    if(!empty($personasInvolucradas)){
                                        echo'<div class="information__container--4">';

                                        foreach($personasInvolucradas as $persona){
                                            echo '
                                            <div class="information__activity--title from_incident-'.$incident->getId().'">
                                                <p class="title__name--2">'.$persona->getNombre().'</p>
                                                <div class="title__container--buttons">
                                                    <button class="container__button--2"><i class="fa-solid fa-xmark fa-xl"></i></button> 
                                                    <button class="container__button--2 edit_person "><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                                                    <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
                                                </div>
                                            </div>
                                            <div class = "activity__information--5 incident__information-hidden">
                                                <div class="information__container information__container--5">
                                                <div class="information__col--4">
                                                    <label>Apellido</label>
                                                    <p class="col__p">'.$persona->getApellido().'</p>
    
                                                    <label>Cedula</label>
                                                    <p class="col__p">'.$persona->getCi().'</p>
                                                    
                                                    <label>Telefono</label>
                                                    <p class="col__p">'.$persona->getTelefono().'</p>
                                                </div>
                                            </div>  
                                        </div>  ';
                                        }

                                        echo '</div>';
                                    }

                                echo'
                            </div>';
                        }
                    }
                    echo '
                        </div>
                        <div class="person--container" id="person--container_'.$incident->getId().'">
                        ';
                    if(!empty($involucrados)){
                        echo '
                        <div class="information__title--activity">
                            <p class="title__name">Involucrados</p><hr class="title__hr">
                        </div>
                        <div class="person-container">
                        ';
                        foreach($involucrados as $involucrado){
                            echo '
                                <div class="involucrado__container ">
                                    <div class="information__activity--title from_incident-'.$incident->getId().'">
                                        <p class="title__name--2">'.$involucrado->getNombre().'</p>
                                        <div class="title__container--buttons">
                                            <button class="container__button--2"><i class="fa-solid fa-xmark fa-xl"></i></button> 
                                            <button class="container__button--2 edit_person from_incidente-'.$incident->getID().'"><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                                            <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
                                        </div>
                                    </div>  
                                    <div class = "activity__information--5 incident__information-hidden">
                                            <div class="information__container information__container--5">
                                            <div class="information__col--4">
                                                <label>Apellido</label>
                                                <p class="col__p">'.$involucrado->getApellido().'</p>

                                                <label>Cedula</label>
                                                <p class="col__p">'.$involucrado->getCi().'</p>
                                                
                                                <label>Telefono</label>
                                                <p class="col__p">'.$involucrado->getTelefono().'</p>
                                            </div>
                                        </div>  
                                    </div>    
                                </div>
                            ';
                        }
                    }
                    echo '
                    </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            ';
        }
}
?>

<div class="activity__information--3 incident__information-hidden">
                            <div class="information__container">
                                <div class="information__col--3">
                                    <label>Descripcion</label>
                                    <p class="col__p">'.$incident->getDescripcion().'</p>
                                </div>
                                <div class="information__col--3">
                                    <label>Fecha</label>
                                    <p class="col__p">'.$incident->getFecha().'</p>
                                    <div></div>
                                    <label>Tipo</label>
                                    <p class="col__p">'.$incident->getTipo().'</p>
                                    
                                    <label>Archivo a descargar</label>
                                    <p class="col__p"><a href="'.loadFile($incident).'" download="archvoRelevante'.$incident->getID().'">Descargar</a></p>
                                </div>
                                <div class="information__col--3">
                                    <label>Nombre y Apellido</label>
                                    <p class="col__p">'.$denunciante->getNombre().' '.$denunciante->getApellido().'</p>

                                    <label>Cedula</label>
                                    <p class="col__p">'.$denunciante->getCi().'</p>
                                    
                                    <label>Telefono</label>
                                    <p class="col__p">'.$denunciante->getTelefono().'</p>
                                </div>
                            </div>
<?php
include_once '../negocio/actividad.php';
include_once '../controladores/getPersonaIncidente.php';
include_once '../controladores/getPersonasActividad.php';

if($_REQUEST['mod'] == 1){
    $actividades = Actividad::getRepo($_REQUEST['id_incidente']);
    if($actividades){
        echo '
        <div class="information__title--activity">
            <p class="title__name">Actividades</p><hr class="title__hr">
        </div>';
    }
    foreach($actividades as $actividad){
        $archivosActividad = $actividad->getFileNames();
        $personasInvolucradas = getPersonasActividad($actividad->getId());
        echo '
        <div class="information__activity--title" id="activity_'.$actividad->getId().'">
            <p class="title__name--2">'.$actividad->getNombre().'</p>
            <div class="title__container">
                <button class="container__button--2 erase_activity--btn"><i class="fa-solid fa-xmark fa-xl"></i></button>
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
                    echo ' 
                    <label>Archivos a descargar</label>
                    <div class="col_downloads">';
                    for($i = 0; $i<count($archivosActividad); $i++){
                        echo '
                        <p class="col__p"><a class="download_action" href="../controladores/downloadFile.php?file='.$archivosActividad[$i][0].'" fileName="'.$archivosActividad[$i][0].'">Descargar '.$i.'</a></p>
                        ';
                    }
                    echo '
                    </div>';
                }
                echo '
                </div>
            </div>
            ';
            if(!empty($personasInvolucradas)){
                echo'
                <div class="information__container--4">';
                foreach($personasInvolucradas as $persona){
                    echo '
                    <div class="information__activity--title--2 from_activity-'.$actividad->getId().'">
                        <p class="title__name--2">'.$persona->getNombre().'</p>
                        <div class="title__container--buttons">
                            <button class="container__button--2 unlink_personActivity"><i class="fa-solid fa-xmark fa-xl"></i></button> 
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
                echo '
                </div>';
                }
    echo'
    </div>';
    }
}elseif($_REQUEST['mod'] == 0){
    $involucrados = getPersonasIncidente($_REQUEST['id_incidente']);
    echo '   
    <div class="information__title--activity">
        <p class="title__name">Involucrados</p><hr class="title__hr">
    </div>
    <div class="person-container">
    ';
    foreach($involucrados as $involucrado){
        echo '
        <div class="involucrado__container">
            <div class="information__activity--title from_incident-'.$_REQUEST['id_incidente'].'">
                <p class="title__name--2">'.$involucrado->getNombre().'</p>
                <div class="title__container--buttons">
                    <button class="container__button--2 unlink_personIncident"><i class="fa-solid fa-xmark fa-xl"></i></button> 
                    <button class="container__button--2 edit_person"><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                    <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
                </div>
            </div>  
            <div class="activity__information--5 incident__information-hidden">
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
    echo '</div>';
}

?>
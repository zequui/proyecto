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
                    <button title="Rechazar incidente" class="container__button reject-incident"><i class="fa-solid fa-x fa-xl"></i></i></button>
                    <button title="Iniciar revición del incidente" class="container__button startIncident_btn"><i class="fa-solid fa-play fa-xl"></i></button>
                    <button title="Deplegar información del incidente" class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl"></i></button>
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
                                <button title="Desetimar incidente" class="container__button desestimar_btn"><i class="fa-solid fa-rectangle-xmark fa-xl"></i></button>
                                <button title="Agregar involucrado" class="container__button addInvolucradoIncidente"><i class="fa-solid fa-user-plus fa-lg"></i></button>
                                <button title="Editar incidente" class="container__button edit_incident"><i class="fa-solid fa-pen-to-square fa-xl"></i></button>
                                <button title="Agregar actividad" class="container__button addActivity"><i class="fa-solid fa-plus fa-2xl"></i></button>';
                                if(isset($_REQUEST['admin_opt'])){
                                    echo    '<button class="container__button instantResolution_btn"><i class="fa-solid fa-check-double fa-2xl"></i></button>';
                                } else {
                        echo    '<button title="Enviar resolucion" class="container__button submitResolution_btn"><i class="fa-solid fa-check fa-2xl"></i></button>';
                                }
        
                        echo    '<button title="Desplegar incidente"class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl"></i></button>
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
                                <button title="Eliminar actividad" class="container__button--2 erase_activity--btn"><i class="fa-solid fa-xmark fa-xl"></i></button>
                                <button title="Editar actividad" class="container__button--2 edit_activity"><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                                <button title="Desplegar actividad" class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
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
                                            <div class="information__activity--title--2" id_incidente="'.$incident->getId().'" id_actividad="'.$actividad->getId().'">
                                                <p class="title__name--2">'.$persona->getNombre().'</p>
                                                <div class="title__container--buttons">
                                                    <button title="Desvincular involucrado" class="container__button--2 unlink_personActivity"><i class="fa-solid fa-xmark fa-xl"></i></button> 
                                                    <button title="Editar involucrado" class="container__button--2 edit_person "><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                                                    <button title="Desplegar involucrado" class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
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
                                    <div class="information__activity--title" id_incidente="'.$incident->getId().'">
                                        <p class="title__name--2">'.$involucrado->getNombre().'</p>
                                        <div class="title__container--buttons">
                                            <button title="Desvincular involucrado" class="container__button--2 unlink_personIncident"><i class="fa-solid fa-xmark fa-xl"></i></button> 
                                            <button title="Editar involucrado" class="container__button--2 edit_person from_incidente-'.$incident->getID().'"><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                                            <button title="Desplegar involucrado" class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
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
            ';
        }
}elseif($filtro == 2){
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
                    <button title="Desplegar resolución" class="container__button displayResolution_btn"><i class="fa-solid fa-inbox fa-xl"></i></button>
                    <button title="Desplegar incidente" class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl active"></i></button>
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
        </div>';
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
                <button title="Desplegar actividad" class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
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
                                <div class="information__activity--title--2" id_incidente="'.$incident->getId().'" id_actividad="'.$actividad->getId().'">
                                    <p class="title__name--2">'.$persona->getNombre().'</p>
                                    <div class="title__container--buttons">
                                    <button title="Desplegar actividad class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
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
                        <div class="information__activity--title" id_incidente="'.$incident->getId().'">
                            <p class="title__name--2">'.$involucrado->getNombre().'</p>
                            <div class="title__container--buttons">
                            <button title="Desplegar involucrado" class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
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
    echo '</div>
    </div>
    
    ';


    }
} elseif($filtro == 5) {
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
                    <button title="Desplegar resolución" class="container__button displayResolution_btn"><i class="fa-solid fa-inbox fa-xl"></i></button>
                    <button title="Desplegar incidente" class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl active"></i></button>
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
        </div>';
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
                <button title="Desplegar actividad" class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
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
                                <div class="information__activity--title--2" id_incidente="'.$incident->getId().'" id_actividad="'.$actividad->getId().'">
                                    <p class="title__name--2">'.$persona->getNombre().'</p>
                                    <div class="title__container--buttons">
                                    <button title="Desplegar actividad class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
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
                        <div class="information__activity--title" id_incidente="'.$incident->getId().'">
                            <p class="title__name--2">'.$involucrado->getNombre().'</p>
                            <div class="title__container--buttons">
                            <button title="Desplegar involucrado" class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
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
    echo '</div>
    </div>
    
    ';
    }
}elseif($filtro == 3){
    foreach($filteredIncidents as $incident){
        $denunciante = getPersonaIncidente_Denunciante($incident->getID());
        $archivos = $incident->getArchivos();
        echo '
        <div class="emergent__incident" id="incident_'.$incident->getID().'">
            <div class="incident__title">
                <p class="title__name">'.$incident->getTitulo().'</p>
                <div class="title__container">
                    <button title="Ver mensaje" class="container__button display-msj"><i class="fa-solid fa-inbox fa-xl"></i></button>
                    <button title="Modificar resolucion" class="container__button displayResolution_btn"><i class="fa-solid fa-play fa-xl"></i></button>
                    <button title="Deplegar información del incidente" class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl"></i></button>
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
}

/*

                <div class="emergent__incident" id="31">
                    <div class="incident__title">
                        <p class="title__name">Grafitearon mi moto</p>
                            <div id="incident__container">
                            <button class="container__button"><i class="fa-solid fa-inbox fa-xl"></i></button>
                                <button class="container__button"><i class="fa-solid fa-check fa-2xl"></i></button>
                                <button class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl active"></i></button>
                            </div>
                    </div>
                    
                    <div class="inicident__information--2">
                        <div class="information__container">
                            <div class="information__col--2">
                                <label>Descripcion</label>
                                <p class="col__p">vfsvfsddvfsvfdsvfdvfdvfd vfedfefvfwfs fdvfvfd fvwvfvfw vfevfdv vfevfdv vfdevfdv vefvefvefv fvevefvfe vfevevfe vfevfevfe vfevfev evefefefvfrefrefer</p>
                            </div>
                            <div class="information__col--2">
                                <label>Fecha</label>
                                <p class="col__p">2023-09-30</p>
                                <label>Tipo</label>
                                <p class="col__p">Vandalismo</p>
                                <label>Archivo a descargar</label>
                                <div class="col_downloads">
                                    <p class="col__p"><a class="download_action" href="../controladores/downloadFile.php?file=archivo_incidente0_12-10-2023_15-58-32.png" filename="archivo_incidente0_12-10-2023_15-58-32.png">Descargar 0</a></p>
                                    <p class="col__p"><a class="download_action" href="../controladores/downloadFile.php?file=archivo_incidente1_12-10-2023_15-58-32.png" filename="archivo_incidente1_12-10-2023_15-58-32.png">Descargar 1</a></p>
                                    <p class="col__p"><a class="download_action" href="../controladores/downloadFile.php?file=archivo_incidente2_12-10-2023_15-58-32.png" filename="archivo_incidente2_12-10-2023_15-58-32.png">Descargar 2</a></p>
                                </div>
                            </div>
                            <div class="information__col--2">
                                <label>Nombre y Apellido</label>
                                <p class="col__p">ezequiel rivero</p>

                                <label>Cedula</label>
                                <p class="col__p">55543952</p>
                                
                                <label>Telefono</label>
                                <p class="col__p">342342423</p>
                            </div>
                        </div>
                        <div class="information__title--activity">
                            <p class="title__name">Actividades</p><hr class="title__hr">
                        </div>
                        <div class="information__activity--title" id="1">
                            <p class="title__name--2">asdadsd</p>
                            <div class="title__container">
                                <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl active"></i></button>
                            </div>
                        </div>
                        <div class="activity__information--3">
                            <div class="information__container--2">
                                <div class="information__col--3">
                                    <label>Descripcion</label>
                                    <p class="col__p">asdasdasd</p>
                                </div>
                                <div class="information__col--3">
                                    <label>Fecha</label>
                                    <p class="col__p">2023-10-12</p>
                                    <label>Tipo</label>
                                    <p class="col__p">Reunion de involucrados</p>
                                </div>
                            </div>
                            <div class="information__container--4">
                                <div class="information__activity--title">
                                    <p class="title__name--2">Rodrigo</p>
                                    <div class="title__container--buttons">
                                        <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
                                    </div>
                                </div>
                                <div class="activity__information--5 incident__information-hidden">
                                    <div class="information__container information__container--5">
                                        <div class="information__col--4">
                                            <label>Apellido</label>
                                            <p class="col__p">Saez</p>

                                            <label>Cedula</label>
                                            <p class="col__p">55449857</p>
                                            
                                            <label>Telefono</label>
                                            <p class="col__p">92050575</p>
                                        </div>
                                    </div>  
                                </div>  
                            </div>
                        </div> 
                        <div class="information__title--activity">
                            <p class="title__name">Involucrados</p><hr class="title__hr">
                        </div>
                        <div class="person-container">
                            <div class="involucrado__container">
                                <div class="information__activity--title">
                                    <p class="title__name--2">ezequi</p>
                                    <div class="title__container--buttons">
                                        <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
                                    </div>
                                </div>  
                                <div class="activity__information--5 incident__information-hidden">
                                    <div class="information__container information__container--5">
                                        <div class="information__col--4">
                                            <label>Apellido</label>
                                            <p class="col__p">zxx<z< p="">

                                            <label>Cedula</label>
                                            </z<></p><p class="col__p">55214412</p>
                                            
                                            <label>Telefono</label>
                                            <p class="col__p">342342342</p>
                                        </div>
                                    </div>  
                                </div>    
                            </div>
                            <div class="involucrado__container">
                                <div class="information__activity--title">
                                    <p class="title__name--2">ezequiel</p>
                                    <div class="title__container--buttons">
                                        <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl active"></i></button>
                                    </div>
                                </div>  
                                <div class="activity__information--5">
                                    <div class="information__container information__container--5">
                                        <div class="information__col--4">
                                            <label>Apellido</label>
                                            <p class="col__p">rivero</p>

                                            <label>Cedula</label>
                                            <p class="col__p">55543952</p>
                                            
                                            <label>Telefono</label>
                                            <p class="col__p">342342423</p>
                                        </div>
                                    </div>  
                                </div>    
                            </div>    
                        </div>
                    </div>
                </div>


 */
?>


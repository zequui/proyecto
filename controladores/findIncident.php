<?php
include_once '../negocio/incidente.php';
include_once '../negocio/actividad.php';
include_once '../controladores/getPersonaIncidente.php';
include_once '../controladores/getPersonasActividad.php';

$resultado = incidente::findIncidente($_REQUEST['data'], $_REQUEST['filter']);
$resultado = array_reverse($resultado);

if(empty($resultado)){
    echo '<p class="title__name">No se encontró ningun incidente</p>';
}else{
    foreach($resultado as $incident){
        $denunciante = getPersonaIncidente_Denunciante($incident->getID());
        $involucrados = getPersonasIncidente($incident->getId());

        $archivosIncidente = $incident->getArchivos();
        
        $actividades = Actividad::getRepo($incident->getID());
    
        echo '
    <div class="emergent__incident" id="incident_'.$incident->getID().'">
        <div class="incident__title">
            <p class="title__name titulo_incidente">'.$incident->getTitulo().'</p>
                <div id="incident__container">
                    <button title="Desplegar resolución" class="container__button displayResolution_btn"><i class="fa-solid fa-inbox fa-xl"></i></button>
                    <button title="Desplegar incidente" class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl active"></i></button>
                </div>
        </div>
        ';
        if($_REQUEST['filter'] == 'titulo'){
            echo'<div class="inicident__information--2 incident__information-hidden">';
        }else{
            echo'<div class="inicident__information--2">';
        }
          
        echo '
            <div class="information__container">
                <div class="information__col--2">
                    <label>Descripcion</label>
                    <p class="col__p descripcion">'.$incident->getDescripcion().'</p>
                </div>
                <div class="information__col--2">
                    <label>Fecha</label>
                    <p class="col__p fecha">'.$incident->getFecha().'</p>
                    <label>Tipo</label>
                    <p class="col__p tipo">'.$incident->getTipo().'</p>
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
}
?>
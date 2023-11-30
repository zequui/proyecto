<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/6b0ad3d290.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="principal.css">
    <title>principal</title>
</head>
<body>
    <div id="main__container">
        <div class="emergent__subMenu subMenu-hidden">
                <a href="../controladores/exitSession.php" class="subMenu__option"><i class="fa-solid fa-right-from-bracket fa-lg"></i>Cerrar sesion</a>
        </div>
        <div id="container">
            <div id="container__navbar">
                <a id="emergentes" class="navbar__element selected">Incidentes emergentes</a>
                <a id="enCurso" class="navbar__element">Incidentes en curso</a>
                <a id="pasados" class="navbar__element">Incidentes pasados</a>
                <a id="Resoluciones" class="navbar__element">
                    Resultado de resoluciones
                    <div class = "notification hidden"></div>
                </a>
               
            </div>
            <?php
                include_once '../negocio/usuario.php';
                session_start();
                if(!isset($_SESSION['usuario logeado']) || !$_SESSION['inicio exitoso']){
                    header('location: ../1_login/inicio_sesion.php');
                }
                $usuario = $_SESSION['usuario logeado'];
                echo '<p id="container__fullname">'.$usuario->getNombre().' '.$usuario->getApellido().'<i class="fa-solid fa-chevron-down"></i></p>';
            ?>

        </div>
        <div class="emergent" id="incidentesEmergentes">
            
            <h1 class=emergent__title>Incidentes emergentes</h1>
            <div class="emergent__container" id="incidentesEmergentes-container">
            </div>
            
        </div>
        <div class="emergent hidden" id="incidenteEnCurso">
            <h1 class=emergent__title>Incidentes en curso</h1>
            <div class="emergent__container" id="onCourse-container">
            </div>
        </div>
        <div class="emergent hidden" id="ResolucionesAdm">
          <h1 class=emergent__title>Resoluciones rechazadas</h1>
          <div class="emergent__container" id="incidentResults-container">             


            </div>
            <div class="activity__information--3 incident__information-hidden">
                <div class="information__container">
                    <div class="information__col--3">
                        <label>Descripcion</label>
                        <p class="col__p">'.$incident-&gt;getDescripcion().'</p>
                    </div>
                    <div class="information__col--3">
                        <label>Fecha</label>
                        <p class="col__p">'.$incident-&gt;getFecha().'</p>
                        <label>Tipo</label>
                        <p class="col__p">'.$incident-&gt;getTipo().'</p>
                        <label>Archivo a descargar</label>
                        <p class="col__p"><a href="'.loadFile($incident).'" download="archvoRelevante'.$incident->getID().'">Descargar</a></p>
                    </div>
                    <div class="information__col--3">
                        <label>Nombre y Apellido</label>
                        <p class="col__p">'.$denunciante-&gt;getNombre().' '.$denunciante-&gt;getApellido().'</p>

                        <label>Cedula</label>
                        <p class="col__p">'.$denunciante-&gt;getCi().'</p>
                        
                        <label>Telefono</label>
                        <p class="col__p">'.$denunciante-&gt;getTelefono().'</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="emergent hidden" id="incidentesPasados">
        <h1 class=emergent__title>Incidentes resueltos</h1>
        <div class="container__inputSearch">
            <input type="text" class="emergent__input" id="incident__locate--input" placeholder="Escribe aquí para buscar entre los incidentes resueltos">
            <select name="incident_data" id="dropdown__opt">
                <option value="titulo">Título</option>
                <option value="descripcion">Descripción</option>
                <option value="fecha">Fecha</option>
            </select>
        </div>
        <div class="emergent__container" id="incidentResolved--container">
            
        </div>
    </div>

    <div id="body__imgContainer">   
    </div>

    <div id="body__container--activity-form" class="container--form--hidden">
    </div>
    <div id="body__container--person-form" class="container--form--hidden">
    </div>
    <div id="body__container--incident-form" class="container--form--hidden">
    </div>
    <div id="body__container--choose-person" class="container--form--hidden">
    </div>
    <div id = "resolution__container--backgroud" class="container--form--hidden">
    </div>


    <div id="emergent__activity--form" class="emergent__activity--hidden">
        <h1 class="emergent__title">Registrar Actividad</h1>
        <div class="activity__container">
            <div class="container__col">
                <div class="col__title">
                    <label>Título</label> 
                    <p class="title__text">(inserte un título facil de identificar)</p>
                </div>
                <input type="text" name="titulo" maxlength="35">
                <label>Descripción</label>
                <textarea class="col__description" name="descripcion"></textarea>
                <div class="col__title">
                    <label>Fecha</label><p class="title__text">(inserte la fecha en la que se realizo la actividad)</p>
                </div>
                <input type="date" name="fecha" class="col__date">
            </div>
            <div class="container__col">
                <label>Tipo de Actividad</label>
                <div class="lista">
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="Toma de testimonios">Toma de testimonios</input>
                    </div>
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="Reunion de involucrados">Reunion de involucrados</input>
                    </div>
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="Reunion del CAP">Reunion del CAP</input>
                    </div>
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="LLamada a padre">LLamada a padres</input>
                    </div>
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="Medidas preventivas">Medidas preventivas</input>
                    </div>
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="Otro">Otro</input>
                    </div>
                </div>
                <label>Archivo relevante</label>
                <input type="file" id="col__file" name="archivos_relevantes" multiple>
                <div class="col__people">
                    <label>Agregar involucrado</label> <button class="container__button--2" id="addInvolucradoActividad"><i class="fa-solid fa-plus fa-xl"></i></button>
                    <div id="PersonasActividades">

                    </div>
                </div>
            </div>
        </div>
        <div class="activity__button">
            <button type="submit" class="form__submit" id="form__activity--submit">Ingresar</button>
        </div>    
    </div>
    <div id="emergent__choose-person--form" class="emergent__activity--hidden">
        <div class="title__container--2">
        <h1 class="emergent__title">Ingresa CI</h1> <button title="Agregar involucrado" class="container__button--2" id="addInvolucrado"><i class="fa-solid fa-plus fa-xl"></i></button>
        </div>
        <input type="text" name="ci" id="CI_search">
        <div id="person--form__result--container">
            
        </div>
        <div class="activity__button">
            <button class="form__submit" id="form__choose-person--submit">Ingresar</button>
        </div>
    </div>
    <div id="emergent__person--form" class="emergent__activity--hidden">
        <h1 class="emergent__title">Registrar Involucrado</h1>
            <div class="container__col--2">
                <div class="col__input">
                    <label>Nombre</label>
                    <input type="text" name="name" maxlength="25" required>
                </div>
                <div class="col__input">
                    <label>Apellido</label>
                    <input type="text" name="surname" maxlength="25" required>
                </div>
                <div class="col__input">
                    <label>Teléfono</label>
                    <input type="number" name="phoneNumber" minlength="8" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                </div>
                <div class="col__input">
                    <label>Cédula</label>
                    <input type="number" name="ci" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                </div>
            </div>
        <div class="activity__button">
            <button class="form__submit" id="form__person--submit">Ingresar</button>
        </div>
    </div>
    <div id="emergent__resolution--form" class="emergent__activity--hidden">
        <div class="container__col">
            <h1 class="emergent__title">Enviar Resolución</h1>
            <label>Descripción</label>
            <textarea class="col__description" name="descripcion"></textarea>
            <label>Tipo de resolución</label>
            <div class="lista">
                <div class="contenedor">
                    <input type="radio" name="tipo" value="Suspensión">Suspensión</input>
                </div>
                <div class="contenedor">
                    <input type="radio" name="tipo" value="Trabajo comunitario">Trabajo comunitario</input>
                </div>
                <div class="contenedor">
                    <input type="radio" name="tipo" value="Cambio de institución">Cambio de institución</input>
                </div>
                <div class="contenedor">
                    <input type="radio" name="tipo" value="Otros">Otros</input>
                </div>
            </div>
        </div>
        <div class="activity__button">
            <button type="submit" class="form__submit" id="form__resolution--submit">Ingresar</button>
        </div>
    </div>
    <div class="emergent__activity--form emergent__activity--hidden" style="display: none;">
        <div class="container__col">
            <h1 class="emergent__title">Resolución</h1>
            <label>Descripción</label>
            <textarea class="col__description" name="descripcion"></textarea>
            <label>Tipo de resolución</label>
            <div class="contenedor__type">Suspención</div>
        </div>
        <div class="activity__button--2">
            <button type="submit" class="form__submit form__submit--2" id="form__activity--submit">Aceptar</button>
            <button type="submit" class="form__submit form__submit--2" id="form__activity--submit">Modificar</button>
        </div>
    </div>

    <div id="emergent__incident--form" class=" emergent__activity--hidden">
        <h1 class="emergent__title">Editar Incidente</h1>
        <div class="activity__container">
            <div class="container__col">
                <div class="col__title">
                    <label>Título</label> <p class="title__text">(inserte un titulo adecuado para ser indentificado mas facilmente)</p>
                </div>
                <input type="text" name="titulo" maxlength="35" required>

                <label>Tipo de incidente</label>
                <div id="lista">
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="Hurto">Hurto</input>
                    </div><div class="contenedor">
                        <input type="radio" name="tipo" value="Acoso">Acoso</input>
                    </div><div class="contenedor">
                        <input type="radio" name="tipo" value="Violencia">Violencia</input>
                    </div><div class="contenedor">
                        <input type="radio" name="tipo" value="Conducta inadecuada">Conducta inadecuada</input>
                    </div><div class="contenedor">
                        <input type="radio" name="tipo" value="Tenencia de sustancias ilicitas">Tenencia de sustancias ilicitas</input>
                    </div><div class="contenedor">
                        <input type="radio" name="tipo" value="Tenencia de objeto dañino">Tenencia de objeto dañino</input>
                    </div><div class="contenedor">
                        <input type="radio" name="tipo" value="Vandalismo">Vandalismo</input>
                    </div>
                </div>
                <div class="col__title">
                    <label>Fecha</label><p class="title__text">(inserte la fecha en la que sucedió el incidente)</p>
                </div>
                <input type="date" name="fecha" id="col__date" required>
                <label>Archivo relevante</label>
                <input type="file" id="col__file" name="archivos_relevantes" multiple>
            </div>
            <div class="container__col">
                <label>Descripción</label>
                <textarea class="col__description" name="descripcion"></textarea>
            </div>
        </div>
        <div class="activity__button">
            <button type="submit" class="form__submit" id="form__incident--submit">Ingresar</button>
        </div>
    </div>

    <div id="emergent__resolution--result" class="emergent__activity--form emergent__activity--hidden" id_incidente = "'.$incident->getId().'">
        <div class="container__col">
            <h1 class="emergent__title">Resolución</h1>
            <label>Descripción</label>
            <div class="col__description" id="resolution-description"></div>
            <label>Tipo de resolución</label>
            <div class="contenedor__type" id="resolution-type"></div>
        </div>
    </div>

    <div class="emergent__activity--form emergent__activity--hidden" id="emergent__mssg--reevaluar">
        <div class="container__col">
            <h1 class="emergent__title">Reevaluar</h1>
            <label>Mensaje</label>
            <div class="col__description"></div>
        </div>
    </div>

    <div id="emergent__resolution--resultModify" class="emergent__activity--form emergent__activity--hidden" id_incidente = "">
            <div class="container__col">
                <h1 class="emergent__title">Resolucion</h1>
                <label>Descripción</label>
                <div class="col__description" id="resolution-description"></div>
                <label>Tipo de resolucion</label>
                <div class="lista">
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="Suspension">Suspensión</input>
                    </div>
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="Trabajo comunitario">Trabajo comunitario</input>
                    </div>
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="cambio de institucion">cambio de institucion</input>
                    </div>
                    <div class="contenedor">
                        <input type="radio" name="tipo" value="otros">otros</input>
                    </div>
                </div>
            </div>
            <div class="activity__button--2">
                <button type="submit" class="form__submit form__submit--2" id="form__resolution-accept">Aceptar</button>
        </div>

    <p id="release"></p>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="app.js" type="module"></script>
</body>
</html>
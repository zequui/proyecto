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
        <div id="container">
            <div id="container__navbar">
                <a id="emergentes" class="navbar__element selected">Incidentes emergentes</a>
                <a id="enCurso" class="navbar__element">Incidentes en curso</a>
                <a id="pasados" class="navbar__element">Incidentes pasados</a>
                <a id="historialIncidentes" class="navbar__element">Historial de Estudiantes</a>
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
            <div class="emergent__subMenu subMenu-hidden">
                <a href="../controladores/exitSession.php" class="subMenu__option"><i class="fa-solid fa-right-from-bracket fa-lg"></i>Cerrar sesion</a>
            </div>
            <h1 class=emergent__title>Incidentes emergentes</h1>
            <div class="emergent__container" id="incidentesEmergentes-container">
            </div>
            
        </div>
        <div class="emergent hidden" id="incidenteEnCurso">
            <div class="emergent__subMenu subMenu-hidden">
                <a href="../controladores/exitSession.php" class="subMenu__option"><i class="fa-solid fa-right-from-bracket fa-lg"></i>Cerrar sesion</a>
            </div>
            <h1 class=emergent__title>Incidentes en curso</h1>
            <div class="emergent__container" id="onCourse-container">
            </div>
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
                    <div id="PesonasActividades">

                    </div>
                </div>
            </div>
        </div>
        <div class="activity__button">
            <button type="submit" class="form__submit" id="form__activity--submit">Ingresar</button>
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

    <div class="emergent__activity--form emergent__activity--hidden" style="display: none;">
        <div class="container__col">
            <h1 class="emergent__title">Enviar Resolucion</h1>
            <label>Descripción</label>
            <textarea class="col__description" name="descripcion"></textarea>
            <label>Tipo de resolucion</label>
            <div class="lista">
                <div class="contenedor">
                    <input type="radio" name="tipo" value="Suspencion">Suspencion</input>
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
        <div class="activity__button">
            <button type="submit" class="form__submit" id="">Ingresar</button>
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
    <p id="release"></p>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="app.js"></script>
</body>
</html>

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
                <a id="resoluciones" class="navbar__element">Resoluciones</a>
                <a id="moderadores" class="navbar__element">Registrar Moderadores</a>
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
        <div class="emergent hidden" id="incidenteResoluciones">
            <h1 class=emergent__title>Resoluciones</h1>
        </div>
        <div class="emergent hidden" id="incidenteModeradores">
            <h1 class=emergent__title>Registrar Moderadores</h1>
            <div id="mod__container">
                <form class="mod__form">
                    <h1 id="form__title">Registrate</h1>
                    <p id="form__text"> Crea una cuenta para registrar inicidentes</p>
                    <div id="form__name">
                        <div id="name__col">
                            <label>Nombre</label>
                            <input type="text" class="mod_input" name="user" required>
                        </div>
                        <div id="name__col">
                            <label>Apellido</label>
                            <input type="text" class="mod_input" name="user" required>
                        </div>
                    </div>

                        <label>Correo electronico o Telefono</label>
                        <input type="text" class="mod_input" name="email" required>

                        <label>Cedula</label>
                        <input type="number" class="mod_input" name="number" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>

                        <div>
                            <label>Contraseña</label>
                            <input type="password" class="mod_input" name="password" required id="password-signin">
                            <i class="fa-solid fa-eye-slash eye" id="seekingBtn"></i>
                        </div>

                        <div>
                            <label>Confirmar contraseña</label>
                            <input type="password" class="mod_input" required id="passwordCheck-signin">
                            <i class="fa-solid fa-eye-slash eye" id="seekingBtn"></i>
                        </div>

                    <p id="password-alert" class="hidden"></p>
                    <button type="submit" class="mod__button">Ingresar</button>  
                </form>
            </div>
        </div>
    </div>
    
    <div id="body__imgContainer">   
    </div>

    <div id="body__container--activity-form" class="container--form--hidden">
    </div>
    <div id="body__container--person-form" class="container--form--hidden">
    </div>


    <div class="emergent__activity--form emergent__activity--hidden">
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

    <div class="emergent__person--form emergent__activity--hidden">
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

    <div class="emergent__activity--form emergent__activity--hidden">
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
            <button type="submit" class="form__submit" id="form__activity--submit">Ingresar</button>
        </div>
    </div>
    <p id="release"></p>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="app.js"></script>
</body>
</html>

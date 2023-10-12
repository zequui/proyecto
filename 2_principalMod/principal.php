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
                <a href="#inicio" id="emergentes" class="navbar__element selected">Incidentes emergentes</a>
                <a href="#acerca" id="enCurso" class="navbar__element">Incidentes en curso</a>
                <a href="#servicios" id="pasados" class="navbar__element">Incidentes pasados</a>
                <a href="#contacto" id="historialIncidentes" class="navbar__element">Historial de Estudiantes</a>
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
            <div id="emergent__subMenu" class="subMenu-hidden">
                <a href="../controladores/exitSession.php" class="subMenu__option"><i class="fa-solid fa-right-from-bracket fa-lg"></i>Cerrar sesion</a>
            </div>
            <h1 class=emergent__title>Incidentes emergentes</h1>
            <div class="emergent__container" id="incidentesEmergentes-container">
            </div>
            
        </div>
        <div class="emergent hidden" id="incidenteEnCurso">
            <h1 class=emergent__title>Incidentes en curso</h1>
            <div class="emergent__container">
                <div class="emergent__incident" id="'.$incident->getID().'">
                    <div class="incident__title">
                        <p class="title__name">'.$incident->getTitulo().'</p>
                            <div id="incident__container">
                            <button class="container__button"><i class="fa-solid fa-rectangle-xmark fa-xl"></i></button>
                                <button class="container__button"><i class="fa-solid fa-pen-to-square fa-xl"></i></button>
                                <button class="container__button"><i class="fa-solid fa-plus fa-2xl"></i></button>
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
                                <p class="col__p">'.$incident->getTipo().'</p>';
                                
                                <label>Archivo a descargar</label>
                                <p class="col__p"><a href="'.loadFile($incident).'" download="archvoRelevante'.$incident->getID().'">Descargar</a></p>';
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
                        <div class="information__activity--title ">
                            <p class="title__name--2">'.$incident->getTitulo().'</p>
                            <div class="title__container">
                                <button class="container__button--2"><i class="fa-solid fa-xmark fa-xl"></i></button>
                                <button class="container__button--2"><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                                <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
                            </div>
                        </div>
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
                                    <p class="col__p">'.$incident->getTipo().'</p>';
                                    
                                    <label>Archivo a descargar</label>
                                    <p class="col__p"><a href="'.loadFile($incident).'" download="archvoRelevante'.$incident->getID().'">Descargar</a></p>';
                                </div>
                            </div>
                            <div class="information__container">
                                <div class="information__col--2">
                                    <label>Nombre y Apellido</label>
                                    <p class="col__p">'.$denunciante->getNombre().' '.$denunciante->getApellido().'</p>

                                    <label>Cedula</label>
                                    <p class="col__p">'.$denunciante->getCi().'</p>
                                    
                                    <label>Telefono</label>
                                    <p class="col__p">'.$denunciante->getTelefono().'</p>
                                </div>
                            </div> 
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p id="release"></p>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="app.js"></script>
</body>
</html>

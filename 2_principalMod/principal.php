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
    <div id="container">
        <div id="container__navbar">
            <a href="#inicio" class="navbar__element">Incidentes emergentes</a>
            <a href="#acerca" class="navbar__element">Incidentes en curso</a>
            <a href="#servicios" class="navbar__element">Incidentes pasados</a>
            <a href="#contacto" class="navbar__element">Historial de Estudiantes</a>
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
    <div class="emergent">
        <div id="emergent__subMenu" class="subMenu-hidden">
            <a href="../controladores/exitSession.php" class="subMenu__option"><i class="fa-solid fa-right-from-bracket fa-lg"></i>Cerrar sesion</a>
        </div>
        <h1 class=emergent__title>Incidentes emergentes</h1>
        <?php
        include_once '../controladores/getIncidents.php';
        include_once '../controladores/loadFiles.php';
        include_once '../controladores/getPersonaIncidente.php';

        $files = glob('../recursos/*');
        if(!empty($files))
            foreach($files as $file){
                unlink($file);
            }

        $incidents=array_reverse(getNewIncidents());
        foreach($incidents as $incident){
            $denunciante = getPersonaIncidente_Denunciante($incident->getID());
            
            echo '
            <div class="emergent__incident" id="'.$incident->getID().'">
                <div class="incident__title">
                <p class="incident__name">'.$incident->getTitulo().'</p>
                    <div class="title__container">
                        <button class="container__button"><i class="fa-solid fa-x fa-xl"></i></i></button>
                        <button class="container__button"><i class="fa-solid fa-check fa-2xl"></i></button>
                        <button class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl"></i></button>
                    </div>
                </div>
                <div class="inicident__information incident__information-hidden">
                    <div class="information__col">
                        <label>Descripcion</label>
                        <p class="col__p">'.$incident->getDescripcion().'</p>
                    </div>
                    <div class="information__col">
                        <label>Fecha</label>
                        <p class="col__p">'.$incident->getFecha().'</p>
                        <div></div>
                        <label>Tipo</label>
                        <p class="col__p">'.$incident->getTipo().'</p>';
                        
                        if(!empty($incident->getArchivo())){
                         echo ' <label>Archivo a descargar</label>
                         <p class="col__p"><a href="'.loadFile($incident).'" download="archvoRelevante'.$incident->getID().'">Descargar</a></p>';
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
        ?>
    </div>
    <br>
    <div class="emergent">
        <h1 class=emergent__title>Incidentes en curso</h1>
        <div class="emergent__incident" id="'.$incident->getID().'">
                <div class="incident__title">
                    <p class="incident__name">'.$incident->getTitulo().'</p>
                        <div id="incident__container">
                            <button class="container__button"><i class="fa-solid fa-x fa-xl"></i></i></button>
                            <button class="container__button"><i class="fa-solid fa-check fa-2xl"></i></button>
                            <button class="container__button dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-2xl"></i></button>
                        </div>
                </div>
                <div class="inicident__information incident__information-hidden">
                    <div class="information__col">
                        <label>Descripcion</label>
                        <p class="col__p">'.$incident->getDescripcion().'</p>
                    </div>
                    <div class="information__col">
                        <label>Fecha</label>
                        <p class="col__p">'.$incident->getFecha().'</p>
                        <div></div>
                        <label>Tipo</label>
                        <p class="col__p">'.$incident->getTipo().'</p>';
                        
                        <label>Archivo a descargar</label>
                         <p class="col__p"><a href="'.loadFile($incident).'" download="archvoRelevante'.$incident->getID().'">Descargar</a></p>';
                    </div>
                    <div class="information__col">
                        <label>Nombre y Apellido</label>
                        <p class="col__p">'.$denunciante->getNombre().' '.$denunciante->getApellido().'</p>

                        <label>Cedula</label>
                        <p class="col__p">'.$denunciante->getCi().'</p>
                        
                        <label>Telefono</label>
                        <p class="col__p">'.$denunciante->getTelefono().'</p>
                    </div>
                    <div class="incident__title">
                    </div>
                </div>
            </div>
    </div>
    <script src="app.js"></script>
</body>
</html>

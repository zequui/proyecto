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
            include '../negocio/usuario.php';
            session_start();
            $usuario = new usuario('dsadasd', 'Lucas', 'Rodriguez', 'lasdadassd', 'abcdefghijlmnopq');
            echo '<p id="container__fullname"><i class="fa-solid fa-right-to-bracket fa-lg"></i>'.$usuario->getNombre().' '.$usuario->getApellido().'</p>';
        ?>
    </div>
    <div id="emergent">
        <h1 id=emergent__title>Incidentes emergentes</h1>
        <div class="emergent__incident">
            <p id="incident__name">inicidente asdasd</p>
            <div id="incident__container">
                <button class="container__button"><i class="fa-solid fa-xmark fa-2xl" style="color: #001f10;"></i></i></button>
                <button class="container__button"><i class="fa-solid fa-check fa-2xl" style="color: #001f10;"></i></button>
                <button class="container__button"><i class="fa-solid fa-arrow-down-long fa-2xl" style="color: #001f10;"></i></button>
            </div>
        </div>
        <div id="inicident__information">
            <p></p>
        </div>
    </div>
</body>
</html>

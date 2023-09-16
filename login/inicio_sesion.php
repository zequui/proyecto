
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inicio_sesion.css">
    <script src="https://kit.fontawesome.com/6b0ad3d290.js" crossorigin="anonymous"></script>
    <title>inicio sesion</title>
</head>
<body>
    <div id="container">
        <form action= "../controladores/loginCheck.php" method="post">
            <h1 id="form__title">Inicie sesion</h1>

            <p id="form__text">Correo electronico</p>
            <input type="email" name="email" required>

            <p id="form__text">Contraseña</p>
            <div class="form__container">
                <input type="password" name="contraseña" id="container__password" required>
                <i class="fa-solid fa-eye-slash fa-xl" id="container__seekingBtn"></i>
            </div>
            
            <a href="../contraseña/contraseña.html" id="form__link">Has olvidado tu contraseña?</a>
            <button type="submit">Ingresar</button>
        </form>
    </div>
 
    <?php
        session_start();
        if(isset($_SESSION['inicio exitoso']) && !$_SESSION['inicio exitoso']){
            echo '<div id="container__error">
                <p>El usuario o contraseña son incorrectos</p>
            </div>';
            unset($_SESSION['inicio exitoso']);
        }
        ?>
    <script src="inicio_sesion.js"></script>
</body>
</html>
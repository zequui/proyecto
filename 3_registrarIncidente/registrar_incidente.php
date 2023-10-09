<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://kit.fontawesome.com/6b0ad3d290.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="registrar_incidente.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>registro de inicidentes</title>
    </head>
    <body>
    <?php
        session_start();
        if(isset($_SESSION['incidente enviado'])){
            if($_SESSION['incidente enviado']){
                echo '
                <div id="container__alert">
                <p id="alert__p">Se ha enviado la informacion</p>
                </div>
                ';
            } else {
                echo '
                <div id="container__alert">
                <p id="alert__p">Hubo un error al enviar el incidente</p>
                </div>
                ';
            }

            unset($_SESSION['incidente enviado']);
        }
        ?>
        <button id="body__button" onclick="location.href='../1_login/inicio_sesion.php'"><i class="fa-solid fa-right-to-bracket"></i>Acceder</button>
        <div id="container">

            <h1 id="container__title">Registrar incidente</h1>
            <p id="container__text"> Por favor complete todos los campos con la informacion correcta</p>

            <form id="container__form" action="../controladores/IncidentSave.php" method="post" enctype="multipart/form-data">
                <div id="form__container">   
                    <div class="container__col">
                        <div class="col__divider">
                            <hr class="divider__hr--1"><h2>Datos personales</h2><hr class="divider__hr--1">
                        </div>
        
                        <div id="container__name">
                            <div id="name__col">
                                <label>Nombre</label>
                                <input type="text" name="name" required>
                            </div>
        
                            <div id="name__col">
                                <label>Apellido</label>
                                <input type="text" name="surname" required>
                            </div>
                        </div>
            
                        <label>Telefono</label>
                        <input type="number" name="phoneNumber" minlength="8" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
        
                        <label>Cedula</label>
                        <input type="number" name="ci" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
        
                        <div class="col__divider">
                            <hr class="divider__hr--2"><h2>incidente</h2><hr class="divider__hr--2">
                        </div>
        
                        <div class="col__title">
                            <label>Titulo</label> <p class="title__text">(inserte un titulo adecuado para ser indentificado mas facilmente)</p>
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
                    </div>
                    <div class="container__col">
                            <div class="col__title">
                            <label>Fecha</label><p class="title__text">(inserte la fecha en la que sucedio el incidente)</p>
                            </div>
                            <input type="date" name="fecha" id="col__date" required>
                            <label>Descripcion</label>
                            <textarea id="col__description" name="descripcion"></textarea>
                            <label>Archivo relevante</label>
                            <input type="file" id="col__file" name="archivo_relevante" multiple>
                    </div>
                </div>
                <button type="submit" id="form__submit">Ingresar</button>
            </form>
        </div> 
    <script src="registrar_incidente.js"></script>
    </body>
</html>
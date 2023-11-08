<?php
include_once '../negocio/usuario.php';

$usuarios = Usuario::getRepo();

foreach($usuarios as $usuario){
    if(!$usuario->getIsAdmin()){
        echo '
        <div class = "mod--container" ci_moderador = "'.$usuario->getCi().'">
            <div class="information__activity--title">
                <p class="title__name--2">'.$usuario->getNombre().'</p>
                <div class="title__container--buttons">
                    <button class="container__button--2 deleteMod_btn"><i class="fa-solid fa-xmark fa-xl"></i></button> 
                    <button class="container__button--2 editMod_btn"><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                    <button class="container__button--2 dropdown_btn"><i class="fa-solid fa-arrow-down-long fa-xl"></i></button>
                </div>
            </div> 
            <div class="activity__information--5 incident__information-hidden">
                <div class="information__container information__container--5">
                    <div class="information__col--4">
                        <label>Apellido</label>
                        <p class="col__p">'.$usuario->getApellido().'</p>
                        
                        <label>cedula</label>
                        <p class="col__p">'.$usuario->getCi().'</p>
                    </div>
                    <div class="information__col--4">
                        <label>Correo</label>
                        <p class="col__p">'.$usuario->getCorreo().'</p>
                        <label>Contraseña</label>
                        <p class="col__p">'.$usuario->getContraseña().'</p>
                    </div>
                </div>  
            </div>     
        </div>
        ';
    }
}
?>
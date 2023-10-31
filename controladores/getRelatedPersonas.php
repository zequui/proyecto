<?php
include_once '../negocio/persona.php';
include_once '../negocio/relaciones.php';

$involucrados = Persona_Incidente::getRepo($_REQUEST['id_incidente']);

foreach($involucrados as $involucrado){
    $persona = $involucrado->getPersona();
    echo '<div class="information__activity--title">
    <p class="title__name--2" ci="'.$persona->getCi().'">'.$persona->getCi().' '.$persona->getNombre().' '.$persona->getApellido().'</p><div class="title__container--buttons--2"><button class="container__button--3 edit_person"><i class = "fa-solid fa-pen-to-square fa-lg"></i></button><button class="container__button--3 checkbox"><i class="fa-regular fa-square fa-xl"></i></button></div>
    </div>';
}
?>
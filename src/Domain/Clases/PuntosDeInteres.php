<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Paquete extends Clase_Base{

    private $idpdi;
    private $nombre;
    private $latitud;
    private $longitud;
    private $puntaje;
    private $descripcion;
    private $imagenes; //esto sería un array que tenga varias url de las imagenes
    private $direccion;
    private $sitioweb;
    private $etiquetas;//un array que tiene distintas etiquetas (ej: restaurante, discoteca, museo, parque)
    private $idubicacion;
}

?>
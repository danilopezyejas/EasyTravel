<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Domain\Clases;

/**
 * Description of PuntosDeInteres
 *
 * @author vanessa
 */
class PuntosDeInteres extends Clase_Base{

    private $nombre;
    private $puntaje;
    private $descripcion;
    private $idubicacion;
    
    public function __construct() {
        if (isset($obj)) {
            foreach ($obj as $key => $value) {
                $this->$key = $value;
            }
        }
        $tabla = "puntos_de_interes";
        parent::__construct($tabla);
    }
    
    function getNombre() {
        return $this->nombre;
    }

    function getPuntaje() {
        return $this->puntaje;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getIdubicacion() {
        return $this->idubicacion;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPuntaje($puntaje) {
        $this->puntaje = $puntaje;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setIdubicacion($idubicacion) {
        $this->idubicacion = $idubicacion;
    }
}

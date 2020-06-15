<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Domain\Clases;

/**
 * Description of DtResenia
 *
 * @author ernesto
 */
class DtResenia {
    
    private $id_resenia;
    private $id_paquete;
    private $id_usuario;
    private $fecha;
    private $descripcion;
    private $valoracion;

    public function __construct($obj = NULL) {
        if (isset($obj)) {
            foreach ($obj as $key => $value) {
                $this->$key = $value;
            }
        }
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    
    public function setIdPaquete($id){
        $this->id_paquete = $id;
    }
    
    public function setIdUsuario($id){
        $this->id_usuario = $id;
    }
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }
    public function setValoracion($valor){
        $this->valoracion = $valor;
    }
    public function getIdPaquete(){
        return $this->id_paquete;
    }
    public function getIdUsuario(){
        return $this->id_usuario;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getValoracion(){
        return $this->valoracion;
    }
    
   
}

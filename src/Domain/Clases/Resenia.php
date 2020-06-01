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
class Resenia extends Clase_Base {
    
    private $id_resenia;
    private $id_paquete;
    private $id_usuario;
    private $fecha_viaje;
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
    public function setFechaViaje($fecha){
        $this->fecha_viaje = $fecha;
    }
    public function setValoracion($valor){
        $this->valoracion = $valor;
    }
    public function agregar(){

    try{
        $sql = "INSERT INTO resenia (id_resenia, id_paquete, id_usuario, fecha_viaje, descripcion, puntos) VALUES
             (:id_paquete, :id_usuario, :fecha_viaje, :descripcion, :puntos)";
        $db = new DB();
        $db = $db->conexionDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':id_paquete', $this->id_paquete);
        $resultado->bindParam(':id_usuario', $this->id_usuario);
        $resultado->bindParam(':fecha_viaje', $this->fecha_viaje);
        $resultado->bindParam(':descripcion', $this->descripcion);
        $resultado->bindParam(':puntos', $this->puntos);

        $resultado->execute();

        $resultado = null;
        $db = null;
        return array('resenia'=> 'Reseña guardada');
   }catch(PDOException $e){
      return $e->getMessage();

   }
    }
    
   
}

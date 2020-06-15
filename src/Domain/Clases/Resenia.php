<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Domain\Clases;
use App\Infrastructure\Persistence\db as DB;
use PDO;

/**
 * Description of Resenia
 *
 * @author ernesto
 */
class Resenia extends Clase_Base {
    
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
    public function agregar(){
        $fecha = date("Y-m-d");
    try{
        $sql = "INSERT INTO resenia (id_resenia, id_paquete, id_usuario, fecha_viaje, descripcion, puntos) VALUES
             (null, :id_paquete, :id_usuario, :fecha, :descripcion, :puntos)";
        $db = new DB();
        $db = $db->conexionDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':id_paquete', $this->id_paquete);
        $resultado->bindParam(':id_usuario', $this->id_usuario);
        $resultado->bindParam(':fecha', $fecha);
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
    
    public function listar($nickname){
        $fecha = date("Y-m-d");
    try{
        $sql = "SELECT 
            CONCAT(t.origenCodigo, '-', t.destinoCodigo) as transporte,
            t.fechaIda as fecha,
            a.nombre as nombre,
            CONCAT(d.ciudad, '/', d.pais) as destino,
            r.descripcion as resenia 
        FROM paquetes p,
            transporte t,
            alojamiento a,
            destino d,
            resenia r,
            usuario u 
        WHERE  p.id_transporte = t.idtransporte
            AND p.id_alojamiento = a.idAlojamiento
            AND p.id_destino = d.idDestino
            AND p.id_paquete = r.id_paquete
            AND r.id_usuario = u.id_usuario
            AND u.nikname = :nickname ";
        $db = new DB();
        $db = $db->conexionDB();
        $resultado = $db->prepare($sql);        
        $resultado->bindParam(':nickname', $nickname);
        $resultado->execute();

        if ($resultado->rowCount() > 0) {
            $resenias = $resultado->fetchAll();
        } else {
            $resenias = array('mensaje' => "No se encontraron resultados");
        }
    return $resenias;
   }catch(PDOException $e){
      return $e->getMessage();

   }
    }
   
}

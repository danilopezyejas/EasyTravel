<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Domain\Clases;

use App\Infrastructure\Persistence\db as DB;
use App\Domain\Clases\Clase_Base as CB;

/**
 * Description of PaquetesComprados
 *
 * @author ernesto
 */
class PaquetesComprados extends Clase_Base {

    private $id_paquete;
    private $id_usuario;
    private $id_transporte;
    private $id_destino;
    private $id_alojamiento;

    public function __construct($obj = NULL) {
        if (isset($obj)) {
            foreach ($obj as $key => $value) {
                $this->$key = $value;
            }
        }
        $tabla = "paquete";
        parent::__construct($tabla);
    }

    public function listaPaquetesComprados($nickname) {
        try {
            $db = new DB();
            $db = $db->conexionDB();
            $stmt = $db->prepare(" SELECT p.id_paquete, d.ciudad, d.pais, a.nombre 
            FROM 
                easytravel.paquetes_comprados p, 
                easytravel.transporte t,
                easytravel.destino d,
                easytravel.alojamiento a,
                easytravel.usuario u  
            WHERE 
                p.id_usuario = u.id_usuario 
                and p.id_transporte = t.idtransporte
                and p.id_destino = d.idDestino
                and p.id_alojamiento = a.idAlojamiento
                and p.id_destino = a.idDestino
               and u.nikname = :nickname 
               order by p.id_paquete");
            $stmt->bindParam(':nickname', $nickname);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                    $paquetes = $stmt->fetchAll();

            } else {
                $paquetes = array('mensaje' => "No se encontraron resultados");
            }
            return $paquetes;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

?>
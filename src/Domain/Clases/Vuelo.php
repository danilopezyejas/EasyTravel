<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Domain\Clases;

use App\Domain\Clases\Clase_Base;
use App\Infrastructure\Persistence\db as DB;

class Vuelo extends Clase_Base{

    private $id;
    private $origenCodigo;
    private $destinoCodigo;
    private $fechaIda;
    private $moneda;
    private $precioTotal;


    function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        $tabla="transporte";
        parent::__construct($tabla);

    }

    function getId() {
        return $this->id;
    }

    function getOrigenCodigo() {
        return $this->origenCodigo;
    }

    function getDestinoCodigo() {
        return $this->destinoCodigo;
    }

    function getFechaIda() {
        return $this->fechaIda;
    }

    function getMoneda() {
        return $this->moneda;
    }

    function getPrecioTotal() {
        return $this->precioTotal;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setOrigenCodigo($origenCodigo) {
        $this->origenCodigo = $origenCodigo;
    }

    function setDestinoCodigo($destinoCodigo) {
        $this->destinoCodigo = $destinoCodigo;
    }

    function setFechaIda($fechaIda) {
        $this->fechaIda = $fechaIda;
    }

    function setMoneda($moneda) {
        $this->moneda = $moneda;
    }

    function setPrecioTotal($precioTotal) {
        $this->precioTotal = $precioTotal;
    }

    public function agregar(){
        $origenCodigo=$this->getOrigenCodigo();
        $destinoCodigo=$this->getDestinoCodigo();
        $fechaIda=$this->getFechaIda();
        $moneda=$this->getMoneda();
        $precioTotal=$this->getPrecioTotal();

        // if(!$this->existe($origenCodigo,$destinoCodigo,$fechaIda)){

            $sql = "INSERT INTO transporte (origenCodigo,destinoCodigo,fechaIda,moneda,precioTotal) VALUES
                     (:o, :d, :fi, :m, :p) ";

              try{
                $db = new DB();
                $db = $db->conexionDB();
                $resultado = $db->prepare($sql);

                $resultado->bindParam(':o', $origenCodigo);
                $resultado->bindParam(':d', $destinoCodigo);
                $resultado->bindParam(':fi', $fechaIda);
                $resultado->bindParam(':m', $moneda);
                $resultado->bindParam(':p', $precioTotal);

                $resultado->execute();
                $resultado = null;
                $db = null;

                return true;
              }catch(PDOException $e){
                $response->getBody()->write( 'Hubo un problema al agregar el vuelo en la base de datos: '.$e->getMessage() );
                return false;
              }
        // }
    }

  public function existe($origenCodigo,$destinoCodigo,$fechaIda){
        $db = new DB();
        $db = $db->conexionDB();
        $stmt = $db->prepare( "SELECT * from  transporte WHERE origenCodigo= :o AND destinoCodigo = :d AND fechaIda= :fi" );
        $stmt->bindParam(':o', $origenCodigo);
        $stmt->bindParam(':d', $destinoCodigo);
        $stmt->bindParam(':fi', $fechaIda);

        $stmt->execute();

        if($stmt->columnCount() > 0){
            return true;
        }else{
          return false;
        }
    }

    public static function getInfo($idVuelo)
    {
      $db = new DB();
      $db = $db->conexionDB();
      $stmt = $db->prepare( "SELECT * from  transporte WHERE  idtransporte = :idTransporte" );
      $stmt->bindParam(':idTransporte', $idVuelo);

      $stmt->execute();
      if($stmt->columnCount() < 1){
          return '';
      }
      $resultado = $stmt->fetch();

      return $resultado;
    }


}//cierra la clase

?>

<?php
namespace App\Domain\Clases;

use App\Infrastructure\Persistence\db as DB;

class Destino extends Clase_Base
{
  private $tabla;

  private $id;
  private $nombre;
  private $latitud;
  private $longitud;
  private $pais;
  private $ciudad;
  private $region;
  private $descripcion;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        $tabla="destino";
        parent::__construct($tabla);
      }

  private function setId($id){
    $this->id = $id;
  }
  private function setNombre($nombre){
    $this->nombre = $nombre;
  }
  public function setPais($pais)
  {
    $this->pais = $pais;
  }
  public function setCiudad($ciudad)
  {
    $this->ciudad = $ciudad;
  }
  public function setLatitud($latitud)
  {
    $this->latitud = $latitud;
  }
  public function setLongitud($longitud)
  {
    $this->longitud = $longitud;
  }
  public function setRegion($region)
  {
    $this->region = $region;
  }
  public function setDescripcion($descripcion)
  {
    $this->descripcion = $descripcion;
  }
  public function getNombre()
  {
    return $this->nombre;
  }
  public function getPais()
  {
    return $this->pais;
  }
  public function getCiudad()
  {
    return $this->ciudad;
  }
  public function getLatitud()
  {
    return $this->latitud;
  }
  public function getLongitud()
  {
    return $this->longitud;
  }
  public function getRegion()
  {
    return $this->region;
  }
  public function getDescripcion()
  {
    return $this->descripcion;
  }
  public function getId()
  {
    return $this->id;
  }

  public function agregar(){

      $id=$this->getId();
      if(!$this->existe($id)){
        $nombre=$this->getNombre();
        $pais=$this->getPais();
        $ciudad=$this->getCiudad();
        $latitud=$this->getLatitud();
        $longitud = $this->getLongitud();
        $region = $this->getRegion();
        $descripcion = $this->getDescripcion();

       $sql = "INSERT INTO destino (idDestino, nombre, pais, ciudad, latitud, longitud, region, descripcion) VALUES
               (:idDestino, :nombre, :pais, :ciudad, :latitud, :longitud, :region, :descripcion)";

      try{
        $db = new DB();
        $db = $db->conexionDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':idDestino', $id);
        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':pais', $pais);
        $resultado->bindParam(':ciudad', $ciudad);
        $resultado->bindParam(':latitud', $latitud);
        $resultado->bindParam(':longitud', $longitud);
        $resultado->bindParam(':region', $region);
        $resultado->bindParam(':descripcion', $descripcion);

        $resultado->execute();

       $resultado = null;
       $db = null;
       return true;
     }catch(PDOException $e){
       $response->getBody()->write( 'Ha ocurrido un error, comuniquese con el administrador' );
       return false;
     }
   }
 }

  public function existe($destino_buscado){
    if($destino_buscado != null){
        $db = new DB();
        $db = $db->conexionDB();
        $stmt = $db->prepare( "SELECT * from  destino WHERE idDestino= :idDestino" );
        $stmt->bindParam(':idDestino', $destino_buscado);

        $stmt->execute();
        if($stmt->columnCount() < 1){
            return false;
        }
        $resultado = $stmt->fetch();

        if($resultado){
          return true;
        }else{
          return false;
        }
    }else{
      return false;
    }
  }

  public function getDestinos()
  {
    $db = new DB();
    $db = $db->conexionDB();
    $stmt = $db->prepare( "SELECT idDestino from  destino" );

    $stmt->execute();
    if($stmt->columnCount() < 1){
        return NULL;
    }else{
      $resultado = $stmt->fetchAll();
      return $resultado;
    }
  }

  public function getDestinosGuardados()
  {
    $db = new DB();
    $db = $db->conexionDB();
    $stmt = $db->prepare( "SELECT ciudad from  destino" );

    $stmt->execute();
    if($stmt->columnCount() < 1){
        return NULL;
    }else{
      $resultado = $stmt->fetchAll();
      return $resultado;
    }
  }

  public static function getDestinoPorCiudad($ciudad)
  {
    $db = new DB();
    $db = $db->conexionDB();
    $stmt = $db->prepare( "SELECT idDestino from  destino WHERE ciudad = :ciudad" );
    $stmt->bindParam(':ciudad', $ciudad);
    $stmt->execute();
    if($stmt->columnCount() < 1){
        return NULL;
    }else{
      $resultado = $stmt->fetch();
      return $resultado;
    }
  }

  public static function destinoAleatorio(){
    $indice = mt_rand(1,50);
    $db = new DB();
    $db = $db->conexionDB();
    $stmt = $db->prepare( "SELECT idDestino FROM destino ORDER BY rand() LIMIT 1 " );
    $stmt->execute();
    if($stmt->columnCount() < 1){
        return NULL;
    }else{
      $resultado = $stmt->fetch();
      return $resultado[0];
    }
  }

}//Fin de la clase

 ?>

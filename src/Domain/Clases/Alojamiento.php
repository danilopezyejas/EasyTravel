<?php
namespace App\Domain\Clases;

use App\Domain\Clases\Clase_Base;
use App\Infrastructure\Persistence\db as DB;

class Alojamiento extends Clase_Base
{
  private $tabla;

  private $nombre;
  private $estrellas;
  private $checkIn;
  private $checkOut;
  private $precio;
  private $descripcion;
  private $idDestino;
  public $idAlojamiento;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key = $value;
            }
        }
        $tabla="alojamiento";
        parent::__construct($tabla);
      }

  public function setIdDestino($idDestino)
  {
    return $this->idDestino;
  }
  public function setNombre($nombre)
  {
    $this->nombre = $nombre;
  }
  public function setEstrellas($estrellas)
  {
    $this->estrellas = $estrellas;
  }
  public function setCheckIn($checkIn)
  {
    $this->checkIn = $checkIn;
  }
  public function setCheckOut($checkOut)
  {
    $this->checkOut = $checkOut;
  }
  public function setPrecio($precio)
  {
    $this->precio = $precio;
  }
  public function setDescripcion($descripcion)
  {
    $this->descripcion = $descripcion;
  }
  public function setIdAlojamiento($idAlojamiento)
  {
    $this->idAlojamiento = $idAlojamiento;
  }

  public function getNombre()
  {
    return $this->nombre;
  }
  public function getEstrellas()
  {
    return $this->estrellas;
  }
  public function getCheckIn()
  {
    return $this->checkIn;
  }
  public function getCheckOut()
  {
    return $this->checkOut;
  }
  public function getPrecio()
  {
    return $this->precio;
  }
  public function getDescripcion()
  {
    return $this->descripcion;
  }
  public function getIdDestino()
  {
    return $this->idDestino;
  }
  public function getIdAlojamiento()
  {
    return $this->idAlojamiento;
  }

  public function agregarDB(){
    $nombre=$this->getNombre();
    $idDestino = $this->getIdDestino();

    if(!$this->existe($nombre, $idDestino)){
      $estrellas=$this->getEstrellas();
      $checkIn=$this->getCheckIn();
      $checkOut=$this->getCheckOut();
      $precio = $this->getPrecio();
      $descripcion = $this->getDescripcion();
      $idAlojamiento = $this->getIdAlojamiento();

      $sql = "INSERT INTO alojamiento (nombre, estrellas, checkIn, checkOut, precio, descripcion, idDestino, idAlojamiento) VALUES
             (:nombre, :estrellas, :checkIn, :checkOut, :precio, :descripcion, :idDestino, :idAlojamiento)";

      try{
        $db = new DB();
        $db = $db->conexionDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':estrellas', $estrellas);
        $resultado->bindParam(':checkIn', $checkIn);
        $resultado->bindParam(':checkOut', $checkOut);
        $resultado->bindParam(':precio', $precio);
        $resultado->bindParam(':descripcion', $descripcion);
        $resultado->bindParam(':idDestino', $idDestino);
        $resultado->bindParam(':idAlojamiento', $idAlojamiento);

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

  public function existe($nombre, $idDestino){
        $db = new DB();
        $db = $db->conexionDB();
        $stmt = $db->prepare( "SELECT * from  alojamiento WHERE nombre= :nombre AND idDestino = :idDestino" );
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':idDestino', $idDestino);

        $stmt->execute();
        if($stmt->columnCount() < 1){
            return '';
        }
        $resultado = $stmt->fetch();

        if($resultado){
          return true;
        }else{
          return false;
        }
    }
}

 ?>

<?php
namespace App\Domain\Clases;

use App\Domain\Clases\Clase_Base;

class Alojamiento extends Clase_Base
{
  private $tabla;

  private $nombre;
  private $estrellas;
  private $checkIn;
  private $checkOut;
  private $precio;
  private $descripcion;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key = $value;
            }
        }
        $tabla="alojamiento";
        parent::__construct($tabla);
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
}

 ?>

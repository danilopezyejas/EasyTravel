<?php

class Alojamiento extends Clase_Base
{
  private $tabla;

  private $nombre;
  private $numHabitaciones;
  private $precio;
  private $descripcion;
  private $imagen;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        $tabla="alojamiento";
        parent::__construct($tabla);
      }
}

 ?>

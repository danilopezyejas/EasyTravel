<?php


class Destino extends Clase_Base
{
  private $tabla;

  private $nombre;
  private $ubicacion;
  private $descripcion;
  
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

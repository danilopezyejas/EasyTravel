<?php

class Restaurant extends Clase_Base
{
  private $tabla;

  private $nombre;
  private $fecha;
  private $ubicacion;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        $tabla="restaurant";
        parent::__construct($tabla);
      }
}

 ?>

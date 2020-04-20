<?php

class Actividades extends Clase_Base
{
  private $tabla;

  private $descripcion;
  private $precio;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        $tabla="actividades";
        parent::__construct($tabla);
  }
}

 ?>

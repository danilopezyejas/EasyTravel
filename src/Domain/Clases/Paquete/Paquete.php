<?php

namespace APP\Domain\Clases\Paquete;

class Paquete extends Controlador_paquetes
{
  private $id;
  private $tipo_transporte;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        // $tabla="peliculas";
        // parent::__construct($tabla);
    }

  public function getId()
  {
    // code...
  }

  public function getTransporte()
  {
    // code...
  }

  public function setId(int $id)
  {
    // code...
  }

  public function setTransporte(int $tipo_transporte)
  {
    // code...
  }


}

 ?>
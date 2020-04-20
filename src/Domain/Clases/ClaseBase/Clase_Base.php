<?php

class Clase_Base
{
  private $tabla;
  private $db;
  private $conectar;
  private $modelo;

  public function __construct($tabla) {
    $this->tabla=(string) $tabla;
    $this->db=DB::conexion();
    $this->modelo=get_class($this);
  }
  
}

 ?>

<?php

namespace App\Domain\Clases;

class DtUsuario 
{
  private $id;
  private $nombre;
  private $apellido;
  private $correo;
  private $nickname;
  private $contrasenia;
  private $residencia;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
  }

 public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id =$id;
  }
  public function getNombre()
  {
    return $this->nombre;
  }
  public function setNombre($nombre)
  {
    $this->nombre = $nombre;
  }
  public function getApellido()
  {
    return $this->apellido;
  }
  public function setApellido($apellido)
  {
    $this->apellido = $apellido;
  }
  public function getCorreo()
  {
    return $this->correo;
  }
  public function setCorreo($correo)
  {
    $this->correo = $correo;
  }
  public function getNickname()
  {
    return $this->nickname;
  }
  public function setNickname($nickname)
  {
    $this->nickname = $nickname;// code...
  }
  public function getContrasenia()
  {
    return $this->contrasenia;
  }
  public function setContrasenia($contrasenia)
  {
    $this->contrasenia = $contrasenia;// code...
  }
  public function getResidencia()
  {
    return $this->residencia;// code...
  }
  public function setResidecia(int $residencia)
  {
    $this->residencia = $residencia;// code...
  }

}

 ?>
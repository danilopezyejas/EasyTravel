<?php
namespace App\Domain\Clases;

class Usuario extends Clase_Base
{
  private $tabla;

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
        $tabla="usuario";
        parent::__construct($tabla);
    }

  public function getPaquetesComprados()
  {
    
  }
  public function getId()
  {
    // code...
  }
  public function setId(int $id)
  {
    // code...
  }
  public function getNombre()
  {
    // code...
  }
  public function setNombre(int $nombre)
  {
    // code...
  }
  public function getApellido()
  {
    // code...
  }
  public function setApellido(int $apellido)
  {
    // code...
  }
  public function getCorreo()
  {
    // code...
  }
  public function setCorreo(int $correo)
  {
    // code...
  }
  public function getNickname()
  {
    // code...
  }
  public function setNickname(int $nickname)
  {
    // code...
  }
  public function getContrasenia()
  {
    // code...
  }
  public function setContrasenia(int $contrasenia)
  {
    // code...
  }public function getResidencia()
  {
    // code...
  }
  public function setResidecia(int $residencia)
  {
    // code...
  }
}

 ?>
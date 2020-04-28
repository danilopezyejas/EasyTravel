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
    // code...
  }
  public function getNombre()
  {
    // code...
  }
  public function getApellido()
  {
    // code...
  }
  public function getCorreo()
  {
    // code...
  }
  
  public function getNickname()
  {
    // code...
  }
  
  public function getContrasenia()
  {
    // code...
  }
  public function getResidencia()
  {
    // code...
  }
}

 ?>
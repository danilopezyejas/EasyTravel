<?php
namespace App\Domain\Controladores;

use App\Domain\Clases\Usuario as Usuario;
use App\Domain\Clases\DtUsuario as DtUsuario;

class Controlador_Usuario{


  private $usuarioLogueado;
  private $usuario;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        // $tabla="paquete";
        // parent::__construct($tabla);
    }

  public static function modificar(DtUsuario $usr)
  {
$usuario = new Usuario();
    $usuario->setNombre($usr->getNombre());
    $usuario->setApellido($usr->getApellido());
    $usuario->setCorreo($usr->getCorreo());
    $usuario->setContrasenia($usr->getContrasenia());
    $usuario->setNickname($usr->getNickname());
    return  $usuario->modificar();
  }
  public function mostraDatos()
  {

  }
  public function listaPaquetesComprados()
  {

  }
  public function getUsuarioLogueado()
  {

  }
  public function ingresoUsuario(DtUsuario $usuario)
  {

  }
  public static function guardarUsuario(DtUsuario $usr)
  {
    $usuario = new Usuario();
    $usuario->setNombre($usr->getNombre());
    $usuario->setApellido($usr->getApellido());
    $usuario->setCorreo($usr->getCorreo());
    $usuario->setContrasenia($usr->getContrasenia());
    $usuario->setNickname($usr->getNickname());
    return  $usuario->agregar();


  }
  public static function login(DtUsuario $usr)
  {
      $usuario = new Usuario();
      $usuario->setNickname($usr->getNickname());
      $usuario->setContrasenia($usr->getContrasenia());
      return  $usuario->login();
  }
  public function logout()
  {
    
  }
}
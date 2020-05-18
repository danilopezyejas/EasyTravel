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
  public static function getUsuarioLogueado(DtUsuario $usr)
  {
    $usuario = new Usuario();
    $usuario->setNickname($usr->getNickname());

    return  $usuario->logueado();

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
  public static function guardarPaquete($idAlojamiento,$idVuelo,$idDestino)
  {
    if(Usuario::guardarPaquete($idAlojamiento,$idVuelo,$idDestino)){
      // $para      =  Session::get('mail');
      $para      = 'lopezyejas@gmail.com';
      $asunto    = 'Reserva en EasyTravel';
      $mensaje   = 'Hola, gracias por preferirnos.';
      $cabeceras = 'From: php.2020.grupo3.tip@gmail.com' . "\r\n" .
                   'Reply-To: php.2020.grupo3.tip@gmail.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
      $mail = mail($para, $asunto, $mensaje, $cabeceras);
      if($mail){
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }
//<<<<<<< HEAD
  
  public  static function existeNick(DtUsuario $usr){
      $usuario = new Usuario();
      $usuario->setNickname($usr->getNickname());
      return $usuario->existeNick();
  }
//}
//=======

}//Fin clase controlador usuario
//>>>>>>> 36fc3c14c724cfbc12d6754a15a47d768d592332

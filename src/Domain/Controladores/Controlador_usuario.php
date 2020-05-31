<?php
namespace App\Domain\Controladores;

use App\Domain\Clases\Usuario as Usuario;
use App\Domain\Clases\DtUsuario as DtUsuario;
use App\Domain\Clases\Alojamiento;
use App\Domain\Clases\Vuelo;
use App\Domain\Clases\Destino;


class Controlador_Usuario{

    static  $logueado = null;
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
  public function setUsuarioLogueado(string $user)
  {
     self::$logueado  = $user;
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
//    $usuario->setNickname(self::$logueado);

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
      $logueado = $usuario->login();
      if ($logueado['nickname'] !== ''){
          self::$logueado = $logueado['nickname'];
         // $this->usuarioLogueado = $logueado['nickname'];
      }
      return $logueado;

  }
  public function logout()
  {
      self::$logueado = null;
  }

  public static function guardarPaquete($idAlojamiento,$idVuelo,$idDestino)
  {
    if(Usuario::guardarPaquete($idAlojamiento,$idVuelo,$idDestino)){
      // $Alojamiento = Alojamiento::getInfo($idAlojamiento);
      // $Vuelo = Vuelo::getInfo($idVuelo);
      $Destino = Destino::getInfo($idDestino);
      $Alojamiento = Alojamiento::getAlojamientos($idAlojamiento);
      $Transporte = Vuelo::getInfo($idVuelo);

      $para      =  $_SESSION['mail'];
      $asunto    = 'Reserva en EasyTravel';
      $mensaje   = "<html lang='es'>
      <head>
      <meta charset='utf-8'>
      <title></title>
      </head>
      <body style='background-color: black '>

      <!--Copia desde aquí-->
      <table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
      <tr>
      <td style='background-color: #ecf0f1; text-align: left; padding: 0'>
      <a href='https://easytraveltip.herokuapp.com/'>
        <img width='20%' style='display:block; margin: 1.5% 3%; clip-path: inset(32% 20% 32% 20%);' src='https://z-p3-scontent.fmvd3-1.fna.fbcdn.net/v/t1.0-9/p960x960/55944984_339372503589359_3080510613827354624_o.jpg?_nc_cat=111&_nc_sid=85a577&_nc_eui2=AeFEPA-ZzqZ9fmnI4oGMuIHixVknnM7c0RjFWSecztzRGMak0eV53xSOrqv1VzGsjtk&_nc_ohc=mAUC08BaMqsAX-EcaYX&_nc_ht=z-p3-scontent.fmvd3-1.fna&_nc_tp=6&oh=5661ef6a3e9bf0820b3a7ecbf06ed5f3&oe=5EF6F99C'>
      </a>
      </td>
      </tr>

      <tr>
      <td style='padding: 0'>
      <img style='padding: 0; display: block' src='https://culturainquieta.com/images/articles/Norways_Breathtaking_Fjords_From_A_Polish_Kayakers_Perspective/Tomasz_Furmanek_Fjord_fiordo_kayak8.jpg' width='100%'>
      </td>
      </tr>

      <tr>
      <td style='background-color: #ecf0f1'>
      <div style='color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
        <h2 style='color: #2261e6; margin: 0 0 7px; text-align: center'>Gracias por confiar en Easy Travel</h2>
        <h3 style='color: #e67e22; margin: 0 0 7px; text-align: center'>Su proximo destino es: ".$Destino['ciudad']." ".$Destino['pais'] ." </h3>
        <p style='margin: 2px; font-size: 15px; text-align: left;'>

        </p>
        <ul style='font-size: 15px;  margin: 10px 0 40px 0 ;'>
          <li><b>Se hospedara en:</b> ".$Alojamiento['nombre']." un hotel de ".$Alojamiento['estrellas']." estrellas</li>
          <li>".$Alojamiento['descripcion'].".</li>
          <li><b>Su vuelo sale el:</b> ".$Transporte['fechaIda']."</li>
        </ul>
        <div style='width: 100%; text-align: center'>
          <a style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db' href='https://easytraveltip.herokuapp.com/'>Ir a la página</a>
        </div>
        <p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Tecnologo en informatica 2020</p>
      </div>
      </td>
      </tr>
      </table>
      <!--hasta aquí-->

      </body>
      </html>
";
      $cabeceras = 'From: Easy Travel php.2020.grupo3.tip@gmail.com' . "\r\n" .
                   'Reply-To: php.2020.grupo3.tip@gmail.com' . "\r\n" .
                   'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" .
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

  public  static function existeNick(DtUsuario $usr){
      $usuario = new Usuario();
      $usuario->setNickname($usr->getNickname());
      return $usuario->existeNick();
  }

}//Fin clase controlador usuario

<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
namespace App\Domain\Clases;
use App\Infrastructure\Persistence\db as DB;

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
  }public function getResidencia()
  {
    return $this->residencia;// code...
  }
  public function setResidecia(int $residencia)
  {
    $this->residencia = $residencia;// code...
  }


  public function login(){
        $db = new DB();
        $db = $db->conexionDB();
        $stmt = $db->prepare( "SELECT * from  usuario WHERE nikname= :nikname AND password= :password " );
        $stmt->bindParam(':nikname', $this->nickname);
        $stmt->bindParam(':password', $this->contrasenia);

        $stmt->execute();
        if($stmt->columnCount() < 1){
            return '';
        }
        $resultado = $stmt->fetch();
        $retorno = array('nickname'=> $this->nickname);

//        Session::init();
//        Session::set('usuario_logueado', true);
//        Session::set('usuario_id', $res->id);
//        Session::set('usuario_nombre', $res->nombre);
//        Session::set('usuario_email', $res->email);
        return $retorno;
    }
    public function agregar(){

        $nombre=$this->getNombre();
        $apellido=$this->getApellido();
        $nickname=$this->getNickname();
        $correo=$this->getCorreo();
        $pass = $this->getContrasenia();


     $sql = "INSERT INTO usuario (nombre, apellido, nikname, correo, password) VALUES
             (:nombre, :apellido, :nickname, :correo, :pass)";

    try{
      $db = new DB();
      $db = $db->conexionDB();
      $resultado = $db->prepare($sql);

      $resultado->bindParam(':nombre', $nombre);
      $resultado->bindParam(':apellido', $apellido);
      $resultado->bindParam(':correo', $correo);
      $resultado->bindParam(':nickname', $nickname);
      $resultado->bindParam(':pass', $pass);

      $resultado->execute();

     $resultado = null;
     $db = null;
     return true;
   }catch(PDOException $e){
     $response->getBody()->write( '{"error" : {"text":'.$e->getMessage().'}}' );
     return false;
   }
 }
     public function modificar(){
//     try{
        $nombre=$this->getNombre();
        $apellido=$this->getApellido();
        $nickname=$this->getNickname();
        $correo=$this->getCorreo();
        $pass = $this->getContrasenia();


     $sql = "update usuario set nombre = :nombre, apellido= :apellido, correo=  :correo, password = :pass
             where nikname= :nickname ";


      $db = new DB();
      $db = $db->conexionDB();
      $resultado = $db->prepare($sql);

      $resultado->bindParam(':nombre', $nombre);
      $resultado->bindParam(':apellido', $apellido);
      $resultado->bindParam(':correo', $correo);
      $resultado->bindParam(':nickname', $nickname);
      $resultado->bindParam(':pass', $pass);

      $resultado->execute();
//       $resultado->fetch();

     $retorno = array('nickname'=> $nickname);
     return $retorno;

//   }catch(PDOException $e){
//     $response->getBody()->write( '{"error" : {"text":'.$e->getMessage().'}}' );
//     return false;
//   }

    }

    public static function guardarPaquete($idAlojamiento,$idVuelo,$idDestino)
    {
      try{
        // $idUsuario = Session::get('idUsuario');
        $idUsuario=2;

        $sql = "INSERT INTO paquetes (id_usuario, id_transporte, id_destino, id_alojamiento ) VALUES
                (:id_usuario, :id_transporte, :id_destino, :id_alojamiento )";

        $db = new DB();
        $db = $db->conexionDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':id_usuario', $idUsuario);
        $resultado->bindParam(':id_transporte', $idVuelo);
        $resultado->bindParam(':id_destino', $idDestino);
        $resultado->bindParam(':id_alojamiento', $idAlojamiento);

        $resultado->execute();

        $resultado = null;
        $db = null;
        return true;
      }catch(PDOException $e){
        $response->getBody()->write( '{"error" : {"text":'.$e->getMessage().'}}' );
        return false;
      }
    }

  }//fin de la clase usuario

 ?>

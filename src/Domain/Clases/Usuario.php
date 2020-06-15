<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
namespace App\Domain\Clases;
use App\Infrastructure\Persistence\db as DB;
use PDO;

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

  public function logueado(){
        try{
        $db = new DB();
        $db = $db->conexionDB();
        $stmt = $db->prepare( "SELECT * from  usuario WHERE nikname= :nikname " );
        $stmt->bindParam(':nikname', $this->nickname);

        $stmt->execute();
        if($stmt->rowCount() < 1){
            return array('nickname'=>'');
        }
        $resultado = $stmt->fetch();
        return  array( 'id_usuario'=> $resultado['id_usuario'],
                        'nickname'=> $resultado['nikname'],
                        'nombre'=> $resultado['nombre'],
                        'apellido'=> $resultado['apellido'],
                        'correo'=> $resultado['correo'] );

//        return $retorno;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
//<<<<<<< HEAD

  public function login(){
      try{
        $db = new DB();
        $db = $db->conexionDB();
        var_dump( $this->contrasenia);
        exit;
        $stmt = $db->prepare( "SELECT * from  usuario WHERE nikname= :nikname " );
        $stmt->bindParam(':nikname', $this->nickname);
        $stmt->execute();
        $user = $stmt->fetch();

        if($user AND ($this->contrasenia == $user['password'])){
            return array('nickname'=> $user['nikname'], 'correo' => $user['correo'], 'idUsuario' => $user['id_usuario']);
        }
        else{
                return  array('nickname'=>'');
        }
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function agregar(){

    try{
        $sql = "INSERT INTO usuario (nombre, apellido, nikname, correo, password) VALUES
             (:nombre, :apellido, :nickname, :correo, :pass)";
        $db = new DB();
        $db = $db->conexionDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $this->nombre);
        $resultado->bindParam(':apellido', $this->apellido);
        $resultado->bindParam(':correo', $this->correo);
        $resultado->bindParam(':nickname', $this->nickname);
        $resultado->bindParam(':pass', $this->contrasenia);

        $resultado->execute();

        $resultado = null;
        $db = null;
        return array('nickname'=> $this->nickname, 'correo' => $this->correo, 'idUsuario' => $this->id);
   }catch(PDOException $e){
      return $e->getMessage();

   }

    }
     public function modificar(){
     try{

     $sql = "update usuario set nombre = :nombre, apellido= :apellido, correo=  :correo, password = :pass
             where nikname= :nickname ";


      $db = new DB();
      $db = $db->conexionDB();
      $resultado = $db->prepare($sql);

      $resultado->bindParam(':nombre', $this->nombre);
      $resultado->bindParam(':apellido', $this->apellido);
      $resultado->bindParam(':correo', $this->correo);
      $resultado->bindParam(':nickname', $this->nickname);
      $resultado->bindParam(':pass', $this->contrasenia);

      $resultado->execute();
      return array('nickname'=> $this->nickname, 'correo' => $this->correo, 'idUsuario' => $this->id);


   }catch(PDOException $e){
     return $e->getMessage();
   }

    }


  public function existeNick(){
      try{
          $sql = "select * from usuario where nikname = :nickname ";
          $db = new DB();
      $db = $db->conexionDB();
      $resultado = $db->prepare($sql);
         $resultado->bindParam(':nickname', $this->nickname);
      $resultado->execute();


      $user = $resultado->fetch();
      if ($user){
        return $user['nikname'];
      }else{
        return '';
      }
      } catch (Exception $ex) {
          return $e->getMessage();
      }
  }


    public static function guardarPaquete($idAlojamiento,$idVuelo,$idDestino)
    {
      try{
        $idUsuario = $_SESSION['idUsuario'];
// $idUsuario = 2;
        $sql = "INSERT INTO paquetes_comprados (id_usuario, id_transporte, id_destino, id_alojamiento ) VALUES
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
        $response->getBody()->write( 'Ha ocurrido un error, comuniquese con el administrador' );
        return false;
      }
    }

  }//fin de la clase usuario



//}
 ?>

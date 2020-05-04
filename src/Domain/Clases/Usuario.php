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
        return  array('nickname'=> $resultado['nikname'],
                        'nombre'=> $resultado['nombre'],
                        'apellido'=> $resultado['apellido'],
                        'correo'=> $resultado['correo'] );

//        return $retorno;
        }catch(PDOException $e){
            return $e->getMessage();     
        }
    }

  public function login(){
      try{
        $db = new DB();
        $db = $db->conexionDB();
        $stmt = $db->prepare( "SELECT * from  usuario WHERE nikname= :nikname " );
        $stmt->bindParam(':nikname', $this->nickname);
        $stmt->execute();
        $user = $stmt->fetch();


        if($user && password_verify($this->contrasenia, $user['password'])){
            return array('nickname'=> $user['nikname']);    
            
        }    
        else{       
                return  array('nickname'=>'');
        }
        }catch(PDOException $e){
            return $e->getMessage();     
        }
    }
    
    public function agregar(): ? bool{

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
        return true;
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
      return array('nickname'=> $this->nickname);
           
          
   }catch(PDOException $e){
     return $e->getMessage();
   }
    
    }
  }

 ?>
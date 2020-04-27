<?php

namespace App\Domain\Controladores;

use App\Domain\Clases\Usuario as Usuario;

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

  public function modificarDatos(DtUsuarios $modificacion)
  {
    // code...
  }
  public function mostraDatos()::DtUsuarios
  {

  }
  public function listaPaquetesComprados()
  {

  }
  public function getUsuarioLogueado()::DtUsuarios
  {

  }
  public function ingresoUsuario(DtUsuarios $usuario)
  {

  }
  public function guardarUsuario()
  {

  }
  public function login()::bool
  {

  }
  public function logout()
  {
    
  }
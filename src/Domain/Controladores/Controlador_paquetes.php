<?php

namespace App\Domain\Controladores;

use App\Domain\Clases\Paquete as Paquete;

class Controlador_Paquetes{


  private $precioMax;
  private $precioMin;
  private $destinos;
  private $tematica;
  private $fecha_viaje;
  private $alojamientos;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        // $tabla="paquete";
        // parent::__construct($tabla);
    }

  public function ingresarDestino(string $destino)
  {
    // code...
  }

  public function ingresarPrecio(int $precioMin, int $precioMax)
  {
    // code...
  }

  public function ingresarFecha(Date $fecha)
  {
    // code...
  }

  public function ingresarTematica(string $tematica)
  {
    // code...
  }

  public function listarPaquetes(string $destino_buscado=null, int $precio_buscado=null, date $fecha_buscada=null, string $tematica_buscada=null)
  {
    $paquetes = new Paquete();
    // $listaPaquetes = $paquetes->getListaPaquetes();
    if($destino_buscado){
      $this->destinos = $paquetes->getListaDestinos($destino_buscado);
      $this->alojamientos = $paquetes->getListaAlojamientos("MAD");
    }
// Si el usuario no selecciono ningun destino entra al if
    // if(!$this->destinos){
    //   $this->destinos = $paquetes->getListaDestinos();
    // }
    if (!$this->alojamientos) {
      $this->alojamientos = $paquetes->getListaAlojamientos();
    }
    $listaPaquetes = array( 'destinos'=>$this->destinos,
                            'alojamientos'=>$this->alojamientos);

    return $listaPaquetes;
  }

  public function comprarPaquete(string $idPaquete)
  {

  }

  public function setDestinos($destinos=null){
    $this->destinos = $destinos;
  }

  public function getDestinos(){
    return $this->destinos;
  }




}

 ?>

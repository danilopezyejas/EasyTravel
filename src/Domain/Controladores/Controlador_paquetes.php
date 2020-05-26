<?php

namespace App\Domain\Controladores;

use App\Domain\Clases\Paquete as Paquete;
use App\Domain\Clases\Destino;

class Controlador_Paquetes{


  private $precioMax;
  private $precioMin;
  private $destinos;
  private $tematica;
  private $fecha_viaje;
  private $alojamientos;
  private $puntosdeinteres;
  private $vuelos;

  private $paquetes;

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

  public function listarPaquetes($destino_buscado=null, $precio_buscado=null, $fecha_buscada=null, $tematica_buscada=null)
  {
    $paquetes = new Paquete();

    if($destino_buscado){
        $destino_buscado = Destino::getDestinoPorCiudad($destino_buscado)['idDestino'];

        $this->destinos = $paquetes->getListaDestinos($destino_buscado);
        $this->alojamientos = $paquetes->getListaAlojamientos($destino_buscado,$fecha_buscada);
        $this->vuelos = $paquetes->getTransporte($destino_buscado, NULL, NULL, $fecha_buscada);
        $this->puntosdeinteres = $paquetes->getListaPuntosDeInteres("41.29694", "2.07833", NULL, NULL);
        //y hacer las convinaciones con varios for
        // $this->crearPaquetes();
       $listaPaquetes = array( 'destinos'=>$this->destinos,
                            'alojamientos'=>$this->alojamientos,
                            'vuelos'=>$this->vuelos,
                            'puntosdeinteres'=>$this->puntosdeinteres);
    }
    else{
        if($precio_buscado){
            //acá es donde tomo en cuenta que haya ingresado un rango de precio y no un destino.
            //entonces devuelvo paquetes por precio y no por destino
            $this->paquetes = $paquetes->getPaquetesPorPrecio($precio_buscado);

            $listaPaquetes = array('paquetes' => $this->paquetes);
        }
        else{
            $listaPaquetes = array('paquetes' => NULL);
        }
    }
// Si el usuario no selecciono ningun destino entra al if
    // if(!$this->destinos){
    //   $this->destinos = $paquetes->getListaDestinos();
    // }
    // if (!$this->alojamientos) {
    //   $this->alojamientos = $paquetes->getListaAlojamientos();
    // }

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

  public static function getDestinosGuardados()
  {
    $destino = new Destino();
    return $destino->getDestinosGuardados();
  }

  // public function crearPaquetes()
  // {
  //   foreach ($this->alojamientos as $key => $value) {
  //     $this->destinos
  //   }
  // }

}

 ?>

<?php

namespace App\Domain\Controladores;

use App\Domain\Clases\Paquete as Paquete;

class Controlador_Paquetes{


  private $precioMax;
  private $precioMin;
  private $destino;
  private $tematica;
  private $fecha_viaje;

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

  public static function listarPaquetes()
  {
    $paquetes = new Paquete();
    $listaPaquetes = $paquetes->getListaPquetes();
    if (isset($_POST['destino'])){
      $listaPaquetes = $paquetes->getListaDestinos($_POST['destino']);
    }

    return $listaPaquetes;
  }

  public function comprarPaquete(string $idPaquete)
  {

  }




}

 ?>

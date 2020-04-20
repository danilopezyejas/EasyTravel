<?php

namespace App\Domain\Controladores;

class Controlador_Paquetes{

  private $precioMax;
  private $precioMin;
  private $destino;
  private $tematica;
  private $fecha_viaje;

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

  public function listarPaquetes()
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v2/shopping/hotel-offers?cityCode=SAN');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Authorization: Bearer tdKubhrH84jmuGAegWK1vB87UAkG';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    echo $result;
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    // return $setPaquetes;
  }

  public function comprarPaquete(string $idPaquete)
  {

  }

}

 ?>

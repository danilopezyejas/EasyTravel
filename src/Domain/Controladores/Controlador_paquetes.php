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
// Obtengo el token
    $token = Controlador_Paquetes::getToken();
// Le pido a
    $destino = new Paquete();
    $paquetes = $destino->getListaPquetes($token);

    return $paquetes;
  }

  public function comprarPaquete(string $idPaquete)
  {

  }

  public static function getToken()
  {
    //Genero el token
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v1/security/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials&client_id=60v7nSAsBAqFhPJGZpLE9sRmS9z8L2b2&client_secret=phWvgwjtlHYnGv1L");

    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//Obtengo toda la informacion en json
    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $json_response=json_decode($result, true);
// Me quedo con access_token que es donde esta el token
    $token = $json_response["access_token"];

    return $token;
  }


}

 ?>

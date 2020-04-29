<?php
namespace App\Domain\Clases;

use App\Domain\Clases\Clase_Base as CB;

class Paquete extends Clase_Base
{
  private $tabla;

  private $id;
  private $tipo_transporte;

  public function __construct($obj=NULL) {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        $tabla="paquete";
        parent::__construct($tabla);
    }

  public function getId()
  {
    // code...
  }

  public function getTransporte()
  {
    // code...
  }

  public function setId(int $id)
  {
    // code...
  }

  public function setTransporte(int $tipo_transporte)
  {

  }

  public function getListaPaquetes():string
      {
  // Obtengo el token
            $token = CB::getToken();

            $ch = curl_init();
//Preparo el curl para hacer la consulta
            curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v2/shopping/hotel-offers?cityCode=MAD');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $headers = array();
            $headers[] = 'Authorization: Bearer '.$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//Obtengo toda la informacion en json
            $resultado = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            $json_response=json_decode($resultado, true);
            $variable=$json_response["data"];
            $alojamiento=array();
            foreach ($variable as $key => $value) {
              $setPaquetes = array('nombre' => $value['hotel'] );
              foreach ($setPaquetes as $key => $value2) {
// Estoy probando aca tendria que crear los alojamientos con lo que obtengo
                $alojamiento = array('nombre'=>$value2['name']);
              }
          }

            return implode($alojamiento);
      }



public function getListaDestinos($destino_buscado)
{
  $token = CB::getToken();

  $ch = curl_init();
  //Preparo el curl para hacer la consulta
  curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v1/reference-data/locations/'.$destino_buscado);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

  $headers = array();
  $headers[] = 'Authorization: Bearer '.$token;
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //Obtengo toda la informacion en json
  $resultado = curl_exec($ch);

  if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
  }
  curl_close($ch);

  $json_response=json_decode($resultado, true);
  $destinos = array('name' => $json_response["data"]["address"]["cityName"],
                    'idLocation' => $json_response["data"]["id"],
                    'idCity' => $json_response ["data"]["address"]["cityCode"],
                    'iataCode' => $json_response ["data"]["iataCode"],
                    'timeZone' => $json_response ["data"]["timeZoneOffset"],
                    'latitude' => $json_response ["data"]["geoCode"]["latitude"],
                    'longitude' => $json_response ["data"]["geoCode"]["longitude"],
                    'country' => $json_response ["data"]["address"]["countryName"],
                    'region' => $json_response ["data"]["address"]["regionCode"]);
  return $destinos;
}
}//cierre de la clase paquete

 ?>

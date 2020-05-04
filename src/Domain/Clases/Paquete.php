<?php
namespace App\Domain\Clases;

use App\Domain\Clases\Clase_Base as CB;
use App\Domain\Clases\Alojamiento;

class Paquete extends Clase_Base
{
  private $tabla;

  private $id;
  private $tipo_transporte;
  private $token;

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

      }

public function getListaAlojamientos($destino_buscado)
{
// Obtengo el token
   $this->token = CB::getToken();

   $ch = curl_init();
//Preparo el curl para hacer la consulta
//GET https://test.api.amadeus.com/v2/shopping/hotel-offers?cityCode=PAR&adults=1&radius=5&radiusUnit=KM&paymentPolicy=NONE&includeClosed=false&bestRateOnly=true&view=FULL&sort=PRICE
   curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v2/shopping/hotel-offers?cityCode='.$destino_buscado.'&adults=1&radius=5&radiusUnit=KM&paymentPolicy=NONE&includeClosed=false&bestRateOnly=true&view=FULL&sort=PRICE');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

   $headers = array();
   $headers[] = 'Authorization: Bearer '.$this->token;
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//Obtengo toda la informacion en json
   $resultado = curl_exec($ch);

   if (curl_errno($ch)) {
       echo 'Error:' . curl_error($ch);
   }
   curl_close($ch);

   $json_response=json_decode($resultado, true);
   $variable=$json_response["data"];
   $alojamientos=[];
// Devuelvo todos los alojamientos que hay en la ciudad que eleji
   foreach ($variable as $key => $value) {
     if($value['hotel'] != NULL) {
       $datos1 = array('nombre'=>$value['hotel']['name'],'estrellas'=>$value['hotel']['rating'],'descripcion'=>$value['hotel']['description']['text']);
     }
     if($value['offers'] != NULL){
       $datos2 = array('chekIn'=>$value['offers'][0]['checkInDate'], 'chekOut'=>$value['offers'][0]['checkOutDate'], 'precio'=>$value['offers'][0]['price']['total']);
     }
     $datos = array_merge($datos1,$datos2);
     $nuevoAlojamiento = new Alojamiento($datos);
     $alojamientos[]=$nuevoAlojamiento;
    }
  return $alojamientos;
}


public function getListaDestinos($destino_buscado)
{
  $this->token = CB::getToken();

  $ch = curl_init();
  //Preparo el curl para hacer la consulta
  curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v1/reference-data/locations/C'.$destino_buscado);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

  $headers = array();
  $headers[] = 'Authorization: Bearer '.$this->token;
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

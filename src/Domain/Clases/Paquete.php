<?php

namespace App\Domain\Clases;

error_reporting(E_ALL);
ini_set('display_errors', '1');

use App\Domain\Clases\Clase_Base as CB;
use App\Domain\Clases\Alojamiento;
use DateTime;

class Paquete extends Clase_Base {

    private $tabla;
    private $id;
    private $tipo_transporte;
    private $token;

    public function __construct($obj = NULL) {
        if (isset($obj)) {
            foreach ($obj as $key => $value) {
                $this->$key = $value;
            }
        }
        $tabla = "paquete";
        parent::__construct($tabla);
    }

    public function getId() {
        // code...
    }

    public function getTransporte($destino_buscado=NULL, $origen=NULL, $cantidadAdultos=NULL, $fechaSalida=NULL) {
         $this->token = CB::getToken();
        //$this->token = "QFc1HgAtB1P4n5CmRhbg8jItTCwI";         
        $ch = curl_init();
        //Preparo el curl para hacer la consulta
        curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=SYD&destinationLocationCode=BKK&departureDate=2020-08-01&adults=1&max=11');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer ' . $this->token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //Obtengo toda la informacion en json
        $resultado = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $json_response = json_decode($resultado, true);
        if ($json_response != NULL) {
            if (isset($json_response)) {
                $aux = $json_response["data"]["0"];
                $fechaSalida = $aux["itineraries"]["0"]["segments"]["0"]["departure"]["at"];
                $fechaSalida = date("Y-m-d H:i", strtotime($fechaSalida));
                $fechaLlegada = $aux["itineraries"]["0"]["segments"]["0"]["arrival"]["at"];
                $fechaLlegada = date("Y-m-d H:i", strtotime($fechaLlegada));
                $vuelos = array(
                    'duracion' => $aux["itineraries"]["0"]["duration"],
                    'ultimaFechaParaComprar' => $aux["lastTicketingDate"],
                    'numeroDeLugaresDisponibles' => $aux["numberOfBookableSeats"],
                    'iataCodeOrigen' => $aux["itineraries"]["0"]["segments"]["0"]["departure"]["iataCode"],
                    'fechaSalida' => $fechaSalida,
                    'iataCodeDestino' => $aux["itineraries"]["0"]["segments"]["0"]["arrival"]["iataCode"],
                    'fechaLlegada' => $fechaLlegada,
                    'currency' => $aux["price"]["currency"],
                    'precioTotal' => $aux["price"]["total"],
                    'id' => $aux["id"]
                );
           } 
            else {
                $vuelos = array('id' => "XXX");
            }
        } else {
            $vuelos = array('id' => "XXX");
        }
        var_dump($vuelos);
        return $vuelos;
    }

    public function setId(int $id) {
        // code...
    }

    public function setTransporte(int $tipo_transporte) {
        
    }

    public function getListaPaquetes(): string {
        
    }

    public function getListaAlojamientos($destino_buscado = NULL, $fecha_buscada = NULL) {
// Obtengo el token
        $this->token = CB::getToken();
        //$this->token = "jP3EwFjhBcMtGkGgGms6FQtNzPiR";

        $ch = curl_init();
//Preparo el curl para hacer la consulta
        // if ($destino_buscado) {
        //   // busqueda aleatoria
        // }
        if ($fecha_buscada) {
            curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v2/shopping/hotel-offers?cityCode=' . $destino_buscado . '&checkInDate=' . $fecha_buscada . '&roomQuantity=1&adults=2&radius=50&radiusUnit=KM&paymentPolicy=NONE&includeClosed=false&bestRateOnly=true&view=FULL&sort=NONE');
        } else {
            curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v2/shopping/hotel-offers?cityCode=' . $destino_buscado . '&adults=1&radius=50&radiusUnit=KM&paymentPolicy=NONE&includeClosed=false&bestRateOnly=true&view=FULL&sort=PRICE');
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer ' . $this->token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//Obtengo toda la informacion en json
        $resultado = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $json_response = json_decode($resultado, true);
        if (isset($json_response["data"])) {
            $variable = $json_response["data"];
            $alojamientos = [];
// Devuelvo todos los alojamientos que hay en la ciudad que eleji
            if ($variable) {
                foreach ($variable as $key => $value) {
                    if (isset($value['hotel'])) {
                        if ($value['hotel'] != NULL) {
                            if (isset($value['hotel']['name'])) {
                                $nombre = array('nombre' => $value['hotel']['name']);
                            } else {
                                $nombre = array('nombre' => "");
                            }
                            if (isset($value['hotel']['rating'])) {
                                $estrellas = array('estrellas' => $value['hotel']['rating']);
                            } else {
                                $estrellas = array('estrellas' => "");
                            }
                            if (isset($value['hotel']['description'])) {
                                $descripcion = array('descripcion' => $value['hotel']['description']['text']);
                            } else {
                                $descripcion = array('descripcion' => "Sin descripcion.");
                            }
                        }
                    } else {
                        $descripcion = array('descripcion' => "Sin descripcion.");
                        $estrellas = array('estrellas' => "");
                        $nombre = array('nombre' => "");
                    }
                    if (isset($value['offers'])) {
                        if ($value['offers'] != NULL) {
                            if (isset($value['offers'][0]['checkInDate'])) {
                                $checkIn = array('checkIn' => $value['offers'][0]['checkInDate']);
                            } else {
                                $checkIn = array('checkIn' => "");
                            }
                            if (isset($value['offers'][0]['checkOutDate'])) {
                                $checkOut = array('checkOut' => $value['offers'][0]['checkOutDate']);
                            } else {
                                $checkOut = array('checkOut' => "");
                            }
                            if (isset($value['offers'][0]['price']['total'])) {
                                $precio = array('precio' => $value['offers'][0]['price']['total']);
                            } else {
                                $precio = array('precio' => "");
                            }
                        }
                    } else {
                        $precio = array('precio' => "");
                        $checkOut = array('checkOut' => "");
                        $checkIn = array('checkIn' => "");
                    }
                    if ($destino_buscado == NULL) {
                        $idDestino = array('idDestino' => "otro");
                    } else {
                        $idDestino = array('idDestino' => $destino_buscado);
                    }
                    $datos = array_merge($nombre, $descripcion, $estrellas, $checkIn, $checkOut, $precio, $idDestino);
                    $nuevoAlojamiento = new Alojamiento($datos);
                    $alojamientos[] = $nuevoAlojamiento;
                }
            }
            return $alojamientos;
        }
    }

    public function getListaDestinos($destino_buscado) {

        $this->token = CB::getToken();
        //$this->token = "H2eX2tPQ2pShv3nxbzaBfAEEwwyY";

        $ch = curl_init();
        //Preparo el curl para hacer la consulta
        curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v1/reference-data/locations/C' . $destino_buscado);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer ' . $this->token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //Obtengo toda la informacion en json
        $resultado = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $json_response = json_decode($resultado, true);
        if ($json_response != NULL) {
            if (isset($json_response["data"])) {
                $destinos = array('ciudad' => $json_response["data"]["address"]["cityName"],
                    'idLocation' => $json_response["data"]["id"],
                    'idCity' => $json_response ["data"]["address"]["cityCode"],
                    'iataCode' => $json_response ["data"]["iataCode"],
                    'timeZone' => $json_response ["data"]["timeZoneOffset"],
                    'latitud' => $json_response ["data"]["geoCode"]["latitude"],
                    'longitud' => $json_response ["data"]["geoCode"]["longitude"],
                    'pais' => $json_response ["data"]["address"]["countryName"],
                    'region' => $json_response ["data"]["address"]["regionCode"],
                    'id' => $destino_buscado);
            } else {
                $destinos = array('id' => "XXX");
            }
        } else {
            $destinos = array('id' => "XYX");
        }
        if ($destino_buscado != NULL) {
            $nuevoDestino = new Destino($destinos);
        }
        return $destinos;
    }

    public function getListaPuntosDeInteres($latitudbuscar, $longitudbuscar) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.triposo.com/api/20200405/local_highlights.json?latitude=' . $latitudbuscar . '&longitude=' . $longitudbuscar . '&poi_fields=all');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resultado = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        //$json_response = json_decode($resultado, true);
        $puntosdeinteres = array('id' => "XXX");
        return $puntosdeinteres;
    }

}

//cierre de la clase paquete
?>

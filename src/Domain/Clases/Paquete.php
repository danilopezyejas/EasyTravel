<?php

namespace App\Domain\Clases;

error_reporting(E_ALL);
ini_set('display_errors', '1');

use App\Domain\Clases\Clase_Base as CB;
use App\Infrastructure\Persistence\db as DB;
use App\Domain\Clases\Alojamiento;
use App\Domain\Clases\PuntosDeInteres;
use DateTime;

class Paquete extends Clase_Base {

    //datos del paquete en si
    private $tabla;
    private $id_paquete;
    private $precio;
    //datos del transporte
    private $id_transporte;
    private $transporte; //esto sería un array con toda la info del transporte
    //datos del alojamiento
    private $id_alojamiento;
    private $alojamiento; //esto sería un array
    private $nombre; //Este es el nombre del hotel
    private $estrellas;
    private $checkIn;
    private $checkOut;
    private $descripcion;
    //datos del destino
    private $id_destino;
    private $destino; //array con todos los datos del destino
    private $ciudad;
    private $pais;
    private $region;
    private $latitud;
    private $longitud;

    //otras variables
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
    function getTabla() {
        return $this->tabla;
    }

    function getId_paquete() {
        return $this->id_paquete;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getId_transporte() {
        return $this->id_transporte;
    }

    function getId_alojamiento() {
        return $this->id_alojamiento;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEstrellas() {
        return $this->estrellas;
    }

    function getCheckIn() {
        return $this->checkIn;
    }

    function getCheckOut() {
        return $this->checkOut;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getId_destino() {
        return $this->id_destino;
    }

    function getCiudad() {
        return $this->ciudad;
    }

    function getPais() {
        return $this->pais;
    }

    function getRegion() {
        return $this->region;
    }

    function getLatitud() {
        return $this->latitud;
    }

    function getLongitud() {
        return $this->longitud;
    }

    function setTabla($tabla) {
        $this->tabla = $tabla;
    }

    function setId_paquete($id_paquete) {
        $this->id_paquete = $id_paquete;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setId_transporte($id_transporte) {
        $this->id_transporte = $id_transporte;
    }

    function setId_alojamiento($id_alojamiento) {
        $this->id_alojamiento = $id_alojamiento;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstrellas($estrellas) {
        $this->estrellas = $estrellas;
    }

    function setCheckIn($checkIn) {
        $this->checkIn = $checkIn;
    }

    function setCheckOut($checkOut) {
        $this->checkOut = $checkOut;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setId_destino($id_destino) {
        $this->id_destino = $id_destino;
    }

    function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    function setPais($pais) {
        $this->pais = $pais;
    }

    function setRegion($region) {
        $this->region = $region;
    }

    function setLatitud($latitud) {
        $this->latitud = $latitud;
    }

    function setLongitud($longitud) {
        $this->longitud = $longitud;
    }


    
    public function getTransporte($destino_buscado=NULL, $origen=NULL, $cantidadAdultos=NULL, $fechaSalida=NULL) {
        $db = new DB();
        $db = $db->conexionDB();
        if (!$destino_buscado && !$origen && !$cantidadAdultos &&!$fechaSalida){
            $resultado = $db->prepare("SELECT * FROM transporte;");
        }
        else{

            $resultado = $db->prepare("SELECT * FROM transporte 
                where origenCodigo='".$origen."' and destinoCodigo='".$destino_buscado."' and 
                fechaIda >=".$fechaSalida);
        }
        $resultado->execute();

        if($resultado->rowCount() > 0){
            while ( $obj = $resultado->fetch() ) {
                //$p = new Paquete($obj);
                $vuelos[] = $obj;
            }
        }
        else {
            $vuelos = array('mensaje' => "No se encontraron resultados");
        }
        $resultado = null;
        $db = null;
        //var_dump($paquetes);

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

//Cambio el formato de la fecha
      $diaIda = substr($fecha_buscada, 3, 2);
      $mesIda = substr($fecha_buscada, 0, 2);
      $anioIda = substr($fecha_buscada, 6, 4);
      $ida = $anioIda."-".$mesIda."-".$diaIda;
      $diaVuelta = substr($fecha_buscada, 16, 2);
      $mesVuelta = substr($fecha_buscada, 13, 2);
      $anioVuelta = substr($fecha_buscada, 19, 4);
      $vuelta = $anioVuelta."-".$mesVuelta."-".$diaVuelta;

//Preparo el curl para hacer la consulta
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v2/shopping/hotel-offers?cityCode='.$destino_buscado.'&adults=1&radius=50&radiusUnit=KM&paymentPolicy=NONE&includeClosed=false&bestRateOnly=true&view=FULL&sort=PRICE');
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

      $json_response = json_decode($resultado, true);
      if (isset($json_response["data"])) {
        $variable = $json_response["data"];
        $alojamientos = [];
// Devuelvo todos los alojamientos que hay en la ciudad que eleji
        if($variable){
           foreach ($variable as $key => $value) {
             if(isset($value['hotel'])){
               if($value['hotel'] != NULL) {
                 if(isset($value['hotel']['name'])){
                 $nombre = array('nombre'=>$value['hotel']['name']);
                 }else{
                   $nombre= array('nombre'=>"");
                 }
                 if(isset($value['hotel']['rating'])){
                   $estrellas = array('estrellas'=>$value['hotel']['rating']);
                 }else{
                   $estrellas = array('estrellas'=>"");
                 }
                 if(isset($value['hotel']['description'])){
                   $descripcion = array('descripcion'=>$value['hotel']['description']['text']);
                 }else{
                   $descripcion = array('descripcion'=>"Sin descripcion.");
                 }
                 if(isset($value['hotel']['hotelId'])){
                   $idAlojamiento = array('idAlojamiento'=>$value['hotel']['hotelId']);
                 }else{
                   $idAlojamiento = array('idAlojamiento'=>"No definido");
                 }
               }
             }else{
               $descripcion = array('descripcion'=>"Sin descripcion.");
               $estrellas = array('estrellas'=>"");
               $nombre= array('nombre'=>"");
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
                   } else{
                     $precio = array('precio' => "");
                   }
                 }else {
               $precio = array('precio' => "");
               $checkOut = array('checkOut' => "");
               $checkIn = array('checkIn' => "");
             }
           }
           if ($destino_buscado == NULL) {
             $idDestino = array('idDestino' => "otro");
           } else {
             $idDestino = array('idDestino' => $destino_buscado);
           }
           $datos = array_merge($nombre, $descripcion, $estrellas, $checkIn, $checkOut, $precio, $idDestino, $idAlojamiento);
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

//    public function getListaPuntosDeInteres($latitudbuscar = NULL, $longitudbuscar = NULL, $precio_buscado = NULL, $tematica_buscada = NULL) {
//        //definir las tematicas segun los rangos de precio
//        //modificar los precios segun se muestren en la busqueda
//        if($precio_buscado&&!$tematica_buscada){
//            if(strcmp ( $precio_buscado, '0-500')== 0){
//                $tematica_buscada = 'beaches|camping|dancing|eatingout';
//            }
//            else if(strcmp ( $precio_buscado, '500-1000')== 0){
//                $tematica_buscada = 'dancing|eatingout|cuisine-Mexican|museums';
//            }
//            else if(strcmp ( $precio_buscado, '1000-1500')== 0){
//                $tematica_buscada = 'cuisine-Vegan|cinema|coffee|cuisine-Italian|history';
//            }
//            else if(strcmp ( $precio_buscado, '1500-+')== 0){
//                $tematica_buscada = 'money|hidden-Expensive|adrenaline|poitype-Casino';
//            }
//        }
//
//
//        //si todos son null
//        if (!$latitudbuscar&&!$longitudbuscar&&!$precio_buscado&&!$tematica_buscada){
//            $url_llamada_api = "https://www.triposo.com/api/20200405/local_highlights.json?latitude=40.49181&longitude=-3.56948&poi_fields=name,score,intro,location_id&account=R2XMW3DG&token=mt4dcdlieh0a5hyvhjere6y3ur4pdaag";
//        }else{
//            if (!$latitudbuscar||!$longitudbuscar){
//                if (isset($precio_buscado) && isset($tematica_buscada)){
//                    $url_llamada_api = 'https://www.triposo.com/api/20200405/local_highlights.json?latitude=40.49181&longitude=-3.56948&tag_labels='.$tematica_buscada.'&poi_fields=name,score,intro,location_id&account=R2XMW3DG&token=mt4dcdlieh0a5hyvhjere6y3ur4pdaag';
//                }
//                else{
//                    $url_llamada_api = 'https://www.triposo.com/api/20200405/local_highlights.json?latitude=40.49181&longitude=-3.56948&poi_fields=name,score,intro,location_id&account=R2XMW3DG&token=mt4dcdlieh0a5hyvhjere6y3ur4pdaag';
//                }
//            }else{
//                $url_llamada_api = 'https://www.triposo.com/api/20200405/local_highlights.json?latitude='.$latitudbuscar.'&longitude='.$longitudbuscar.'&poi_fields=name,score,intro,location_id&account=R2XMW3DG&token=mt4dcdlieh0a5hyvhjere6y3ur4pdaag';
//            }
//        }
//
//
//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_URL, $url_llamada_api);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//
//        $resultado = curl_exec($ch);
//        if (curl_errno($ch)) {
//            echo 'Error:' . curl_error($ch);
//        }
//        curl_close($ch);
//
//
//        $json_response = json_decode($resultado, true);
//        //var_dump($json_response);
//        if ($json_response != NULL) {
//            if (isset($json_response)) {
//                if (isset($json_response["results"])) {
//                    if (isset($json_response["results"]["0"]["pois"]["0"])) {
//                        $pois = $json_response["results"]["0"]["pois"];
//                        foreach($pois as $key => $value){
//                            $nombre = array('nombre' => $value["name"]);
//                            $descripcion = array('descripcion' => $value["intro"]);
//                            $idubicacion = array('idubicacion' => $value["location_id"]);
//                            $datos = array_merge($nombre,$descripcion,$idubicacion);
//                            $nuevoPoi = new PuntosDeInteres($datos);
//                            $puntosdeinteres[] = $nuevoPoi;
//                        }
//                    }else {
//                        $puntosdeinteres = array('id' => "XXX");
//                    }
//                }else {
//                    $puntosdeinteres = array('id' => "XXX");
//                }
//            } else {
//                $puntosdeinteres = array('id' => "XXX");
//            }
//        } else {
//            $puntosdeinteres = array('id' => "XXX");
//        }
//        return $puntosdeinteres;
//    }

    public function getPaquetesPorPrecio($precio_buscado=NULL){

        $db = new DB();
        $db = $db->conexionDB();
        if (!$precio_buscado){
            $resultado = $db->prepare("select id_paquete,id_transporte,id_alojamiento,
                                    id_destino,paquetes.precio,alojamiento.nombre,alojamiento.estrellas,
                                    alojamiento.checkIn,alojamiento.checkOut,alojamiento.descripcion,
                                    destino.ciudad, destino.pais, destino.region, destino.latitud, destino.longitud
                                    from paquetes
                                    inner join alojamiento, destino, transporte
                                    where paquetes.id_alojamiento= alojamiento.idAlojamiento
                                    and paquetes.id_destino=destino.idDestino
                                    and paquetes.id_transporte=transporte.idTransporte
                                    ");
        }
        else{
            if(strcmp ( $precio_buscado, "500")== 0){
                $query = "paquetes.precio<500";
            }
            else if(strcmp ( $precio_buscado, "500-1000")== 0){
                $query = "paquetes.precio>499 and paquetes.precio<1000";
            }
            else if(strcmp ( $precio_buscado, '1000-1500')== 0){
                $query = "paquetes.precio>999 and paquetes.precio<1500";
            }
            else if(strcmp ( $precio_buscado, '1500')== 0){
                $query = "paquetes.precio>1499";
            }

            $resultado = $db->prepare("select id_paquete,id_transporte,id_alojamiento,
                                    id_destino,paquetes.precio,alojamiento.nombre,alojamiento.estrellas,
                                    alojamiento.checkIn,alojamiento.checkOut,alojamiento.descripcion,
                                    destino.ciudad, destino.pais, destino.region, destino.latitud, destino.longitud
                                    from paquetes
                                    inner join alojamiento, destino, transporte
                                    where paquetes.id_alojamiento= alojamiento.idAlojamiento
                                    and paquetes.id_destino=destino.idDestino
                                    and paquetes.id_transporte=transporte.idTransporte and ".$query);
        }
        $resultado->execute();

        if($resultado->rowCount() > 0){
            while ( $obj = $resultado->fetch() ) {
                //$p = new Paquete($obj);
                $paquetes[] = $obj;
            }
        }
        else {
            $paquetes = array('mensaje' => "No se encontraron resultados");
        }
        $resultado = null;
        $db = null;
        //var_dump($paquetes);

        return $paquetes;
    }
    
    public function getPaquetesPorDestino($destino_buscado=NULL,$precio_buscado=NULL,$fecha_buscada=NULL,$tematica_buscada=NULL){
        $this->destinos = $this->getListaDestinos($destino_buscado);
        $this->alojamientos = $this->getListaAlojamientos($destino_buscado, $fecha_buscada);
        $this->transporte = $this->getTransporte($destino_buscado, NULL, NULL, $fecha_buscada);

        $paquetes = [];
        foreach ($this->alojamientos as $key => $value) {
            foreach ($this->transporte as $key2 => $value2) {
                $this->agregarDB();
            }
        }

        return;
    }
      public function agregarDB(){

      $sql = "INSERT INTO alojamiento (id_transporte, id_alojamiento, id_destino, precio) VALUES
             (:id_transporte, :id_alojamiento, :id_destino, :precio)";

      try{
        $db = new DB();
        $db = $db->conexionDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':id_transporte', $this->transporte);
        $resultado->bindParam(':id_alojamiento', $this->alojamiento);
        $resultado->bindParam(':id_destino', $this->destino["id"]);
        $resultado->bindParam(':precio', $this->precio);

        $resultado->execute();
        $resultado = null;
        $db = null;
        return true;
      }catch(PDOException $e){
        $response->getBody()->write( 'Ocurrió un error, comuniquese con el administrador.' );
        return false;
      }
    
  }

}//cierre de la clase paquete
?>

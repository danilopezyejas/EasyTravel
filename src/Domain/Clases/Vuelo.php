<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Domain\Clases;

use App\Domain\Clases\Clase_Base;

class Vuelo extends Clase_Base{
    
    private $origenCodigo;
    private $destinoCodigo;
    private $ultimaFechaEmision;
    private $cantidadDeAsientosReservables;
    private $idaDuracion;
    private $fechaIda;
    private $moneda;
    private $precioTotal;
    private $aerolinea;
    private $opcionTarifa;
    private $tipoViajeros;
    
    
    function __construct() {
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }
        }
        $tabla="vuelos";
        parent::__construct($tabla);
        
    }
    
    function getOrigenCodigo() {
        return $this->origenCodigo;
    }

    function getDestinoCodigo() {
        return $this->destinoCodigo;
    }

    function getUltimaFechaEmision() {
        return $this->ultimaFechaEmision;
    }

    function getCantidadDeAsientosReservables() {
        return $this->cantidadDeAsientosReservables;
    }

    function getIdaDuracion() {
        return $this->idaDuracion;
    }

    function getFechaIda() {
        return $this->fechaIda;
    }

    function getMoneda() {
        return $this->moneda;
    }

    function getPrecioTotal() {
        return $this->precioTotal;
    }

    function getAerolinea() {
        return $this->aerolinea;
    }

    function getOpcionTarifa() {
        return $this->opcionTarifa;
    }

    function getTipoViajeros() {
        return $this->tipoViajeros;
    }

    function setOrigenCodigo($origenCodigo) {
        $this->origenCodigo = $origenCodigo;
    }

    function setDestinoCodigo($destinoCodigo) {
        $this->destinoCodigo = $destinoCodigo;
    }

    function setUltimaFechaEmision($ultimaFechaEmision) {
        $this->ultimaFechaEmision = $ultimaFechaEmision;
    }

    function setCantidadDeAsientosReservables($cantidadDeAsientosReservables) {
        $this->cantidadDeAsientosReservables = $cantidadDeAsientosReservables;
    }

    function setIdaDuracion($idaDuracion) {
        $this->idaDuracion = $idaDuracion;
    }

    function setFechaIda($fechaIda) {
        $this->fechaIda = $fechaIda;
    }

    function setMoneda($moneda) {
        $this->moneda = $moneda;
    }

    function setPrecioTotal($precioTotal) {
        $this->precioTotal = $precioTotal;
    }

    function setAerolinea($aerolinea) {
        $this->aerolinea = $aerolinea;
    }

    function setOpcionTarifa($opcionTarifa) {
        $this->opcionTarifa = $opcionTarifa;
    }

    function setTipoViajeros($tipoViajeros) {
        $this->tipoViajeros = $tipoViajeros;
    }

function getVuelo($origen = null, $destino = null, $fechaSalida = null , $adultos = null){
    
    //si dentro de los parametros no llega ningun valor, o si alguno es null
    //entonces lo que se hace es cargar las variales siguientes con unos valores predeterminados
    //que se sabe de antemano sirven para esta llamada de api
    //lo hice así, porque me parece que sirve tanto para si no llega ningun valor o si solo falta uno
    if (!$origen){
        $origen = "SYD";
    }if (!$destino){
        $destino = "BKK";
    }if (!$fechaSalida){
        $fechaSalida = 2020-08-01;
    }if (!$adultos){
        $adultos = 2;
    } 
    
    // Obtengo el token
   $this->token = CB::getToken();

   $ch = curl_init();
//Preparo el curl para hacer la consulta
   curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v2/shopping/flight-offers?
       originLocationCode='.$origen.'&
       destinationLocationCode='.$destino.'&
       departureDate='.$fechaSalida.'&
       adults='.$adultos.'&
       max=3');
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
    
   
}//cierra la funcion get vuelo

}//cierra la clase

?>
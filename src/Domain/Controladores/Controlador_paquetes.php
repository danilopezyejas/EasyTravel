<?php

namespace App\Domain\Controladores;

use App\Domain\Clases\Paquete as Paquete;
use App\Domain\Clases\PaquetesComprados as PaquetesComprados;
use App\Domain\Clases\Resenia as Resenia;
use App\Domain\Clases\Destino;
use App\Infrastructure\Persistence\db as DB;


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
    $imagenes = $paquetes->getImagenes();
    if($precio_buscado==null){
      if($destino_buscado==null){
        $destino_buscado = Destino::destinoAleatorio();
      }else{
        $destino_buscado = Destino::getDestinoPorCiudad($destino_buscado)['idDestino'];
      }
      //acá es donde tomo en cuenta que haya ingresado un rango de precio y no un destino.
      //entonces devuelvo paquetes por precio y no por destino
      $this->paquetes = $paquetes->getPaquetesPorDestino($destino_buscado,$precio_buscado,$fecha_buscada,$tematica_buscada);
    }else{
      if($destino_buscado!=null){
        $destino_buscado = Destino::getDestinoPorCiudad($destino_buscado)['idDestino'];
        $this->paquetes = $paquetes->getPaquetesPorPrecio($destino_buscado,$precio_buscado);
      }
    }

    $listaPaquetes = array('paquetes' => $this->paquetes,
                           'imagenes' => $imagenes
                         );

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

  public static function getPaquetesComprados($nickname)
  {
    $paquetesComprados = new PaquetesComprados();
    //$paquetesComprados->listaPaquetesComprados($nickname);

    $paquetes = array('paquetes' => $paquetesComprados->listaPaquetesComprados($nickname));
    return $paquetes;
  }

  public static function getResenias($nickname)
  {
    $reseniasHechas = new Resenia();
    $resenias = array('resenias' => $reseniasHechas->listar($nickname));
    return $resenias;
  }
  // public function crearPaquetes()
  // {
  //   foreach ($this->alojamientos as $key => $value) {
  //     $this->destinos
  //   }
  // }


  public static function verResenias(){
        $db = new DB();
        $db = $db->conexionDB();
        $stmt = $db->prepare( "SELECT distinct concat(d.ciudad, '-', d.pais) as ciudad, u.nikname as nombre, r.puntos, r.descripcion
                                FROM resenia r
                                inner join usuario u on r.id_usuario=u.id_usuario
                                left join paquetes p on r.id_paquete=p.id_paquete
                                left join destino d on p.id_destino=d.idDestino
                                order by id_resenia desc limit 4");

        $stmt->execute();
        if($stmt->columnCount() < 1){
            return '';
        }
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

}

 ?>

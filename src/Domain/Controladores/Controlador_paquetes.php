<?php
namespace APP\Domain\Controlador_paquetes;

class Controlador_paquetes{

  private $tabla;
  private $db;
  private $conectar;
  private $modelo;

  private $precioMax;
  private $precioMin;
  private $destino;
  private $tematica;
  private $fecha_viaje;

  public function __construct($tabla) {
    $this->tabla=(string) $tabla;
    $this->db=DB::conexion();
    $this->modelo=get_class($this);
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

  public function listarPaquetes()
  {
    return $setPaquetes;
  }

  public function comprarPaquete(string $idPaquete)
  {
    // code...
  }

}

 ?>

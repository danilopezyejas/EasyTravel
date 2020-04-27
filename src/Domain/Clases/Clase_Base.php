<?php
namespace App\Domain\Clases;

use App\Infrastructure\Persistence\DB as DB;

class Clase_Base
{
  private $tabla;
  private $db;
  private $conectar;
  private $modelo;

  public function __construct($tabla) {
    $this->tabla=(string) $tabla;
    $this->db=DB::conexionDB();
    $this->modelo=get_class($this);
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

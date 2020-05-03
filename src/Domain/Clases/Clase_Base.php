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
    // $this->tabla=(string) $tabla;
    // $this->db=DB::conexionDB();
    // $this->modelo=get_class($this);
  }

  public static function getToken()
  {
//Capturo las variables de entorno definidas con el heroku client
    $my_client_id = '4IEGmwQwjg6z7SvseQeGP9ZM03BAwjlr';//getenv('CLIENT_ID');
    $my_client_secret = 'vrF4p7A3HPy54quK';//getenv('CLIENT_SECRET');

//Inicio curl
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://test.api.amadeus.com/v1/security/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials&client_id=".$my_client_id."&client_secret=".$my_client_secret);

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

<?php
namespace App\Infrastructure\Persistence;
use PDO;
//require_once ('config\config.php');

  class db{
    private $dbHost = '127.0.0.1';
    private $dbUser = 'root';
    private $dbpass = 'pao2930';
    private $dbName = 'easytravel';

    /*public function conexionDB()
    {
      $mysqlConnect = "mysql:host="+DB_HOST+";dbname="+DB_DB;
      $dbConexion = new PDO($mysqlConnect,DB_USR,DB_PASS);
      $dbConexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $dbConexion;
    }*/
    public function conexionDB()
    {
      $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
      $dbConexion = new PDO($mysqlConnect, $this->dbUser, $this->dbpass);
      $dbConexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $dbConexion;
    }
  }
 ?>

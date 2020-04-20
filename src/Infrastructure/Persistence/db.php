<?php
  require_once ('..\..\..\config\config.php');

  class DB{
    private $dbHost = '127.0.0.1';
    private $dbUser = 'root';
    private $dbpass = '';
    private $dbName = 'db_easyTravel';

    public function conexionDB()
    {
      $mysqlConnect = "mysql:host="+DB_HOST+";dbname="+DB_DB;
      $dbConexion = new PDO($mysqlConnect,DB_USR,DB_PASS);
      $dbConexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $dbConexion;
    }
  }
 ?>

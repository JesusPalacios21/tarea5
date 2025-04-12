<?php

//Clase de conexión SERVER > BD
class Database{

  private static $host = "localhost";
  private static $dbname = "cursos";
  private static $username = "root";
  private static $password = "";
  private static $charset = "utf8mb4";
  private static $conexion = null;

  public static function getConexion(){
    if (self::$conexion === null){
      try{
        //Estructurar la cadena de conexión
        //En este caso mi puerto es 3307(cmabiar de puerto si se utiliza otro)
        $DSN = "mysql:host=" . self::$host . ";port=3307;dbname=" . self::$dbname . ";charset=" . self::$charset;
        $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ];

        //Asignando una conexión activa
        self::$conexion = new PDO($DSN, self::$username, self::$password, $options);
      }
      catch(PDOException $e){
        throw new PDOException($e->getMessage());
      }
    }

    return self::$conexion;
  }

  public static function closeConexion(){
    self::$conexion = null;
  }

}
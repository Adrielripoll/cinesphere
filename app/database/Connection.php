<?php 

namespace app\database;

class Connection {

    private static $conn = null;

    public static function connection(){

        if(static::$conn){
            return static::$conn;
        }

        $host = "127.0.0.1";
        $usuario = "adriel";
        $senha = "1234";
        $dbname = "movies_db";

        static::$conn = mysqli_connect($host, $usuario, $senha, $dbname);

        if(static::$conn->connect_error){ 
            die(static::$conn->connect_error);
        }

        return static::$conn;
    }
}

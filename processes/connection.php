<?php

class Database{


    public static $Conection;

    public static function connect(){
        if(Database::$Conection == null){
            Database::$Conection = new mysqli("localhost","root","password","phpViva","3306");
        }
    }

    public static function search($query){
        Database::connect();
        $result = Database::$Conection->query($query);
        return $result;
    }

    public static function iud($query){
        Database::connect();
        Database::$Conection->query($query);
    }

}


















?>
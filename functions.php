<?php

//Conexion a la base de datos

function conexion(){
    try {
        $conexion = @new PDO(
            'mysql:host=localhost;dbname=flota',//host and name of DataBase
            'root',//user
            '',//Password from user in MySql
            array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
        );
    }catch (PDOException $e) {
        echo $e -> getMessage();
    }
    return $conexion;
}



//For a localhost DataBase conecction
// try {
//     $conexion = @new PDO(
//         'mysql:localhost;dbname=flota',
//         'root',
//         '', //Just in case you don't set an user with password
//         array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
//     );
// }catch (PDOException $e) {
//     echo $e -> getMessage();
// }
// return $conexion;
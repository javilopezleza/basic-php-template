<?php

//Conexion a la base de datos

function conexion(){
    try {
        $conexion = @new PDO(
            'mysql:host=your-host-name;dbname=your-database-name',//host and name of DataBase
            'your-user',//user
            'your-password',//Password from user in MySql
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
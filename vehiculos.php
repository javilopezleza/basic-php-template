<?php
include "functions.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehiculos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body class="container-fluid">

    <h1>Vehículos</h1>
    <span>Los datos presentes son ficticios cualquier coincidencia ocurrida no es más que una casualidad</span>

    <span class="to-top"> <i class="bi bi-chevron-up"></i> </span>

    <?php include_once "header.php"; ?>


    <?php

    $conexion = conexion();

    $sentencia = $conexion->prepare("SELECT vehiculo.matricula, vehiculo.modelo, conductor.nombre, vehiculo_conductor.fecha, conductor.puesto
                                     FROM vehiculo
                                     INNER JOIN vehiculo_conductor ON vehiculo.matricula = vehiculo_conductor.vehiculo
                                     INNER JOIN conductor ON conductor.id = vehiculo_conductor.conductor
                                     ORDER BY conductor.puesto ASC");
    $sentencia->execute();

    $numFilas  = $sentencia->rowCount();

    if ($numFilas > 1) {
        $fila = $sentencia->fetch();
    }
    ?>

    <table class="table table-striped">
        <tr>
            <th>Matricula</th>
            <th>Modelo</th>
            <th>Nombre del conductor</th>
            <th>Fecha</th>
            <th>Puesto</th>
        </tr>

        <?php
        do {
            echo "<tr>
            <td>{$fila['matricula']}</td>
            <td>{$fila['modelo']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['fecha']}</td>
            <td>{$fila['puesto']}</td>
            </tr>";
        } while ($fila = $sentencia->fetch());

        ?>
    </table>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="js/apps.js"></script>

</body>

</html>
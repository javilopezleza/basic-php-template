<?php

include "functions.php";



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conductores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include_once "header.php"; ?>
    <h1>Conductores</h1>


    <?php

    $conexion = conexion();

    $sentencia = $conexion->prepare("SELECT * 
                                    FROM conductor
                                    WHERE puesto = 'director' 
                                    OR puesto = 'informatica'
                                    ORDER BY nombre ASC");
    $sentencia->execute();

    $numFilas  = $sentencia->rowCount();

    if ($numFilas > 1) {
        $fila = $sentencia->fetch();
    }
    ?>

    <table class="table table-striped">
        <tr>
            <th>Nombre</th>
            <th>Fecha caducidad</th>
            <th>Puesto</th>
        </tr>

        <?php
            do {
                echo "<tr>";
                echo "<td>{$fila['nombre']}</td>";
                echo "<td>{$fila['fecha_caducidad']}</td>";
                echo "<td>{$fila['puesto']}</td>";
                echo "</tr>";
            } while ($fila = $sentencia->fetch());

            ?>
    </table>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
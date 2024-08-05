<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehiculos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include_once "header.php"; ?>
<?php
include_once "functions.php";

$pdo = conexion();
if (!$pdo) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

$mensaje = "";
$valormatricula = "";
$valorbastidor = "";
$id = "";

// Capturar id
$editarMatricula = isset($_GET["matricula"]) ? $_GET["matricula"] : "";

// Capturar accion
$accion = isset($_GET["accion"]) ? $_GET["accion"] : "";

if ($accion == "borrar") {
    $sql = "DELETE FROM vehiculo WHERE matricula = :matricula";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':matricula' => $editarMatricula]);

    if ($stmt->rowCount() == 0) {
        $mensaje = "No se ha borrado ningún registro";
    } else {
        $mensaje = "Vehículo borrado";
    }
}

// Si se ha pulsado el botón de grabar, modificar registro
if (isset($_POST["grabar"])) {
    $matricula = isset($_POST["matricula"]) ? trim($_POST["matricula"]) : "";
    $bastidor = isset($_POST["bastidor"]) ? trim($_POST["bastidor"]) : "";
    $marca = isset($_POST["marca"]) ? trim($_POST["marca"]) : "";
    $modelo = isset($_POST["modelo"]) ? trim($_POST["modelo"]) : "";
    $proxima_revision = isset($_POST["proxima_revision"]) ? trim($_POST["proxima_revision"]) : "";

    if ($matricula == "" || $bastidor == "" || $marca == "" || $modelo == "" || $proxima_revision == "") {
        $mensaje = "Los campos tienen que estar rellenos";
    } else {
        $sql = "UPDATE vehiculo SET bastidor = :bastidor, marca = :marca, modelo = :modelo, proxima_revision = :proxima_revision WHERE matricula = :matricula";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':matricula' => $matricula,
            ':bastidor' => $bastidor,
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':proxima_revision' => $proxima_revision
        ]);

        if ($stmt->rowCount() == 0) {
            $mensaje = "No se ha modificado ningún registro";
        } else {
            $mensaje = "Vehículo modificado";
        }
    }
}

// Si se ha pulsado el botón de nuevo, crear nuevo registro
if (isset($_POST["nuevo"])) {
    $matricula = isset($_POST["nuevo_matricula"]) ? trim($_POST["nuevo_matricula"]) : "";
    $bastidor = isset($_POST["nuevo_bastidor"]) ? trim($_POST["nuevo_bastidor"]) : "";
    $marca = isset($_POST["nuevo_marca"]) ? trim($_POST["nuevo_marca"]) : "";
    $modelo = isset($_POST["nuevo_modelo"]) ? trim($_POST["nuevo_modelo"]) : "";
    $proxima_revision = isset($_POST["nuevo_revision"]) ? trim($_POST["nuevo_revision"]) : "";

    if ($matricula == "" || $bastidor == "" || $marca == "" || $modelo == "" || $proxima_revision == "") {
        $mensaje = "Los campos tienen que estar rellenos";
    } else {
        $sql = "INSERT INTO vehiculo (matricula, bastidor, marca, modelo, proxima_revision) VALUES (:matricula, :bastidor, :marca, :modelo, :proxima_revision)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':matricula' => $matricula,
            ':bastidor' => $bastidor,
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':proxima_revision' => $proxima_revision
        ]);

        if ($stmt->rowCount() == 0) {
            $mensaje = "No se ha creado ningún registro";
        } else {
            $mensaje = "Nuevo vehículo creado";
        }
    }
}

// Cargar datos para el listado, siempre después de hacer los cambios
$sql = "SELECT matricula, bastidor, marca, modelo, proxima_revision FROM vehiculo";
$stmt = $pdo->query($sql);
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<form action='?' method='POST'>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Matricula</th>
                <th>Bastidor</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Proxima revisión</th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Cargar datos de vehiculoes
            if (isset($resultado)) {
                foreach ($resultado as $row) {
                    if ($row["matricula"] == $editarMatricula && $accion == "editar") {
                        // Fila con edición
                        echo "<tr><td><input type='text' name='matricula' value='" . $row["matricula"] . "'/></td>";
                        echo "<td><input type='text' name='bastidor' value='" . $row["bastidor"] . "'/></td>";
                        echo "<td><input type='text' name='marca' value='" . $row["marca"] . "'/></td>";
                        echo "<td><input type='text' name='modelo' value='" . $row["modelo"] . "'/></td>";
                        echo "<td><input type='text' name='proxima_revision' value='" . $row["proxima_revision"] . "'/></td>";
                        echo "<td><input type='submit' name='grabar' value='Grabar'><input type='submit' name='cancelar' value='Cancelar'></td></tr>";
                        echo "<input type='hidden' name='id' value='" . $row['matricula'] . "'/>";
                    } else {
                        // Fila sin edición
                        echo "<tr><td>" . $row["matricula"] . "</td>";
                        echo "<td>" . $row["bastidor"] . "</td>";
                        echo "<td>{$row['marca']}</td>";
                        echo "<td>{$row['modelo']}</td>";
                        echo "<td>{$row['proxima_revision']}</td>";
                        echo "<td><a href='crud.php?matricula=" . utf8_encode($row['matricula']) . "&accion=editar'><i class='bi bi-pencil edit'></i></a></td>";
                        echo "<td><a href='crud.php?matricula=" . utf8_encode($row['matricula']) . "&accion=borrar'><i class='bi bi-trash delete'></i></a></td></tr>";
                    }
                }
            }
            ?>
            <tr>
                <td><input class="input-group" type='text' name='nuevo_matricula' placeholder="Nueva matricula"/></td>
                <td><input class="input-group" type='text' name='nuevo_bastidor' placeholder="Nuevo bastidor"/></td>
                <td><input class="input-group" type='text' name='nuevo_marca' placeholder="Nueva marca"/></td>
                <td><input class="input-group" type='text' name='nuevo_modelo' placeholder="Nuevo modelo"/></td>
                <td><input class="input-group" type='text' name='nuevo_revision' placeholder="Nueva revision"/></td>
                <td><input class="btn btn-success" type='submit' name='nuevo' value='Nuevo'></td>
            </tr>
        </tbody>
    </table>
</form>
<div class="feedback">
    <p><?php echo $mensaje; ?></p>
</div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>

<?php
session_start();
include_once "functions.php";

// Inicializar conexión a la base de datos
$pdo = conexion();
if (!$pdo) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

// Generar un token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$mensaje = "";
$accion = isset($_GET["accion"]) ? trim($_GET["accion"]) : "";
$matricula = isset($_GET["matricula"]) ? trim($_GET["matricula"]) : "";

// Verificar la acción y realizar la operación correspondiente
if (isset($_POST["nuevo"])) {
    // Verificar token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token mismatch.");
    }

    $matricula = isset($_POST["nuevo_matricula"]) ? trim($_POST["nuevo_matricula"]) : "";
    $bastidor = isset($_POST["nuevo_bastidor"]) ? trim($_POST["nuevo_bastidor"]) : "";
    $marca = isset($_POST["nuevo_marca"]) ? trim($_POST["nuevo_marca"]) : "";
    $modelo = isset($_POST["nuevo_modelo"]) ? trim($_POST["nuevo_modelo"]) : "";
    $proxima_revision = isset($_POST["nuevo_revision"]) ? trim($_POST["nuevo_revision"]) : "";

    if ($matricula == "" || $bastidor == "" || $marca == "" || $modelo == "" || $proxima_revision == "") {
        $mensaje = "Los campos tienen que estar rellenos";
    } else {
        $_SESSION['temp_data'][] = [
            'matricula' => $matricula,
            'bastidor' => $bastidor,
            'marca' => $marca,
            'modelo' => $modelo,
            'proxima_revision' => $proxima_revision
        ];
        $mensaje = "Nuevo vehículo añadido temporalmente";
    }
}

if ($accion === "editar" && $matricula !== "") {
    // Verificar token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token mismatch.");
    }

    $bastidor = isset($_POST["bastidor"]) ? trim($_POST["bastidor"]) : "";
    $marca = isset($_POST["marca"]) ? trim($_POST["marca"]) : "";
    $modelo = isset($_POST["modelo"]) ? trim($_POST["modelo"]) : "";
    $proxima_revision = isset($_POST["proxima_revision"]) ? trim($_POST["proxima_revision"]) : "";

    if ($bastidor == "" || $marca == "" || $modelo == "" || $proxima_revision == "") {
        $mensaje = "Los campos tienen que estar rellenos";
    } else {
        foreach ($_SESSION['temp_data'] as &$item) {
            if ($item['matricula'] === $matricula) {
                $item['bastidor'] = $bastidor;
                $item['marca'] = $marca;
                $item['modelo'] = $modelo;
                $item['proxima_revision'] = $proxima_revision;
                break;
            }
        }
        $mensaje = "Vehículo editado temporalmente";
    }
}

if ($accion === "borrar" && $matricula !== "") {
    foreach ($_SESSION['temp_data'] as $key => $item) {
        if ($item['matricula'] === $matricula) {
            unset($_SESSION['temp_data'][$key]);
            $_SESSION['temp_data'] = array_values($_SESSION['temp_data']); // Reindexar el array
            break;
        }
    }
    $mensaje = "Vehículo eliminado temporalmente";
}

// Cargar datos para el listado
$data = $_SESSION['temp_data'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="container-fluid">
    <?php include_once "header.php"; ?>

    <h1>CRUD</h1>
    <span>Por razones de seguridad los datos agregados serán temporales y solo estarán presentes hasta el final de la sesión</span>

    <form action='?' method='POST'>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Bastidor</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Próxima revisión</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["matricula"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row["bastidor"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row["marca"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row["modelo"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row["proxima_revision"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td><a href='?matricula=" . urlencode($row['matricula']) . "&accion=editar'><i class='bi bi-pencil edit'></i></a></td>";
                    echo "<td><a href='?matricula=" . urlencode($row['matricula']) . "&accion=borrar'><i class='bi bi-trash delete'></i></a></td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td><input class="input-group" type='text' name='nuevo_matricula' placeholder="Nueva matrícula" /></td>
                    <td><input class="input-group" type='text' name='nuevo_bastidor' placeholder="Nuevo bastidor" /></td>
                    <td><input class="input-group" type='text' name='nuevo_marca' placeholder="Nueva marca" /></td>
                    <td><input class="input-group" type='text' name='nuevo_modelo' placeholder="Nuevo modelo" /></td>
                    <td><input class="input-group" type='text' name='nuevo_revision' placeholder="Nueva revisión" /></td>
                    <td><input class="btn btn-success" type='submit' name='nuevo' value='Nuevo' /></td>
                </tr>
            </tbody>
        </table>
    </form>
    <div class="feedback">
        <p><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

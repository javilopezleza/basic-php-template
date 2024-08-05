<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rest</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="rest container-fluid">

        <h2>Servicio API REST</h2>
        <span class="fw-bold">Datos extraídos de <a target="blank" href="https://pokeapi.co/docs/v2">Pokeapi</a> </span>

        <form class="d-flex flex-wrap" action="#" method="GET">
            <label class="w-100" for="numero">Introduce un número: </label>
            <input class="form-control w-25 mx-2 my-2" type="text" name="numero" id="numero" placeholder="Número">
            <button class="btn btn-success my-2" type="submit" name="submit" id="submit">Enviar</button>
        </form>

        <div class="d-flex justify-content-around align-items-center my-5">

            <div class="mainInfo">

                <?php
                // Función para manejar las solicitudes cURL
                function fetchFromApi($url)
                {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $data = curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($http_code != 200) {
                        return null;
                    }

                    return json_decode($data, true);
                }

                $id = null;
                $next_id = null;
                $prev_id = null;

                if (isset($_GET['numero'])) {
                    $id = $_GET['numero'];
                    $next_id = $id + 1;
                    $prev_id = $id - 1;
                    $pokemonUrl = "https://pokeapi.co/api/v2/pokemon/$id/";

                    $resultados = fetchFromApi($pokemonUrl);

                    if (!$resultados || !isset($resultados['forms']) || !isset($resultados['sprites']) || !isset($resultados['types']) || !isset($resultados['species']['url'])) {
                        echo "<h2 class='my-2'>Pokemon no disponible</h2>";
                    } else {
                        $results = $resultados['forms'];
                        $resultsImage = $resultados['sprites'];
                        $resultsTypes = $resultados['types'];
                        $speciesUrl = $resultados['species']['url'];

                        foreach ($results as $result) {
                            $name = $result["name"];
                            $url = $resultsImage["front_default"];
                            $urlBack = isset($resultsImage["back_default"]) ? $resultsImage["back_default"] : null;
                            $shinyUrl = $resultsImage["front_shiny"];
                            $shinyUrlBack = isset($resultsImage["back_shiny"]) ? $resultsImage["back_shiny"] : null;

                            echo "<h2 class='text-capitalize'>$name</h2>";
                            echo "<div class='d-flex'>";
                            echo "<div class='me-3'>";
                            echo "<h5>Normal</h5>";
                            echo "<img src='{$url}' style='width:150px; height:150px;'><br>";
                            if ($urlBack) {
                                echo "<img src='{$urlBack}' style='width:150px; height:150px;'><br>";
                            }
                            echo "</div>";
                            echo "<div class='me-3'>";
                            echo "<h5>Shiny</h5>";
                            echo "<img src='{$shinyUrl}' style='width:150px; height:150px;'><br>";
                            if ($shinyUrlBack) {
                                echo "<img src='{$shinyUrlBack}' style='width:150px; height:150px;'><br>";
                            }
                            echo "</div>";
                            echo "</div>";
                ?>
            </div>

            <div class='types'>
                <h3>Tipos y Generación</h3>
                <ul>
                <?php
                            foreach ($resultsTypes as $type) {
                                $typeName = $type['type']['name'];
                                echo "<li class='fw-bold fs-5 text-capitalize'>$typeName</li>";
                            }
                        }
                ?>
                </ul>
                <?php
                        $species = fetchFromApi($speciesUrl);
                        if ($species) {
                            $generationUrl = $species['generation']['url'];
                            $generation = fetchFromApi($generationUrl);
                            if ($generation) {
                                $generationName = $generation['name'];
                                echo "<h3>Generación: <span class='fw-bold text-capitalize'>$generationName</span></h3>";
                            }
                ?>
            </div>
            <div class="evoChain">
                <?php
                            $evolutionUrl = $species['evolution_chain']['url'];
                            $evolutionChain = fetchFromApi($evolutionUrl);

                            // Función para mostrar la cadena de evolución con enlaces
                            function mostrarCadenaEvolucion($chain)
                            {
                                $id = getIdFromUrl($chain['species']['url']);
                                echo "<li class='fw-bold text-capitalize fs-5 list-group-item w-100'><a class='link-dark' href='?numero=$id'>" . $chain['species']['name'] . "</a></li>";
                                if (!empty($chain['evolves_to'])) {
                                    foreach ($chain['evolves_to'] as $evolucion) {
                                        mostrarCadenaEvolucion($evolucion);
                                    }
                                }
                            }

                            // Función para obtener el ID del Pokémon desde la URL
                            function getIdFromUrl($url)
                            {
                                $urlParts = explode('/', rtrim($url, '/'));
                                return end($urlParts);
                            }
                ?>
                <h3>Cadena de Evolución</h3>
                <ul>
                    <?php
                            mostrarCadenaEvolucion($evolutionChain['chain']);
                    ?>
                </ul>
    <?php
                        }
                    }
                }
    ?>
            </div>

        </div>
    </div>
    <div class="d-flex justify-content-around my-5">
        <?php
        if ($id !== null && $id > 1) { ?>
            <div class="prev">
                <?php echo "<h3><a class='link-dark text-decoration-none' href='?numero=$prev_id'> Ir al anterior </a></h3>"; ?>
            </div>
        <?php
        }
        ?>
        <div class="next">
            <?php
            if ($id !== null) {
                echo "<h3><a class='link-dark text-decoration-none' href='?numero=$next_id'> Ir al siguiente </a></h3>";
            }
            ?>
        </div>
    </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</body>

</html>
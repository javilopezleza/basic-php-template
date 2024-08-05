<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <?php
    include_once "../../imports.php";
    ?>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


    <?php
    include_once "../../projectsHeader.php";
    include_once "header.php";
    ?>



    <h2>Ventajas y desventajas de PHP</h2>
    <ul class="nav nav-tabs mx-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active but" id="ventajas-tab" data-bs-toggle="tab" data-bs-target="#ventajas" type="button" role="tab" aria-controls="ventajas" aria-selected="true">Ventajas</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link but" id="desventajas-tab" data-bs-toggle="tab" data-bs-target="#desventajas" type="button" role="tab" aria-controls="desventajas" aria-selected="false">Desventajas</button>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="ventajas" role="tabpanel" aria-labelledby="ventajas-tab">
            <ol class="type">
                <li class="mx-2 my-1">Lenguaje totalmente libre y abierto.</li>
                <li class="mx-2 my-1">Posee una curva de aprendizaje muy baja.</li>
                <li class="mx-2 my-1">Los entornos de desarrollo son de rápida y fácil configuración.</li>
                <li class="mx-2 my-1">Fácil de instalar: existen paquetes autoinstalables que integran PHP rápidamente.</li>
                <li class="mx-2 my-1">Fácil acceso e integración con la bases de datos.</li>
                <li class="mx-2 my-1">Posee una comunidad muy grande.</li>
                <li class="mx-2 my-1">Es el lenguaje con mayor usabilidad en el mundo.</li>
                <li class="mx-2 my-1">Es un lenguaje multiplataforma.</li>
                <li class="mx-2 my-1">Completamente orientado al desarrollo de aplicaciones web dinámicas y/o páginas web con acceso a una Base de Datos.
                </li>
                <li class="mx-2 my-1">El código escrito en PHP es invisible al navegador ya que se ejecuta al lado del servidor y los resultados en el navegador es HTML.
                </li>
                <li class="mx-2 my-1">Posee una versatilidad para la conexión con la mayoría de base de datos que existen en la actualidad.</li>

            </ol>



        </div>
        <div class="tab-pane fade" id="desventajas" role="tabpanel" aria-labelledby="desventajas-tab">

            <ol class="type">
                <li class="my-1 mx-2 short"> El inconveniente es que el código fuente no pueda ser ocultado de una manera eficiente. La ofuscación es una técnica que puede dificultar la lectura del código y, en ciertos aspectos representa tiempos de ejecución.</li>
                <li class="my-1 mx-2 short">Nuestro código estará seguro para ejecutar si es nuestro propio servidor. Por lo tanto, si un cliente requiere su código en su pc, tendríamos que dejar el código fuente, sin manera de ocultarlo, aunque hay muchas aplicaciones para PHP que nos ayuda a encriptar el código fuente.</li>
                <li class="my-1 mx-2 short">Si no lo configuras y/o proteges correctamente dejas abiertas muchas brechas de seguridad que a la larga nos causaran problemas.</li>
                <li class="my-1 mx-2 short">Solo se ejecuta en un servidor y se necesita un servidor web para que funcione.</li>




            </ol>

        </div>

    </div>


    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <script src="js/apps.js"></script>
</body>

</html>
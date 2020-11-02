<?php
//ESTO SIEMPRE ES LO PRIMERO
session_start();

header("Refresh:5 url=juegaciam.php");
// Establecer tiempo de vida de la sesión en segundos
$inactividad = 60 * 15;
// Comprobar si $_SESSION["timeout"] está establecida
if (isset($_SESSION["timeout"])) {
    // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactividad) {
        session_destroy();
        header("Location: logout.php");
    }
}

// El siguiente key se crea cuando se inicia sesión
$_SESSION["timeout"] = time();


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>PHP</title>
    <header>

        <div id="container" style="margin-left: 22%; margin-bottom: -5%;">

            <p ><a href="#" >JuegaCiam</a></p>


        </div>
    </header>
</head>

<body>
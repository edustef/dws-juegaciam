<?php

use edustef\mvcFrame\Application;

$app = Application::$app;
$successFlash = $app->session->getFlashSession('success');
//CABECERA DE HTML

// header("Refresh:5 url=juegaciam");
// Establecer tiempo de vida de la sesión en segundos
$inactividad = 60 * 15;
// Comprobar si $_SESSION["timeout"] está establecida
if (isset($_SESSION["timeout"])) {
	// Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	$sessionTTL = time() - $_SESSION["timeout"];
	if ($sessionTTL > $inactividad) {
		session_destroy();
		header("Location: login.php");
	}
}

// El siguiente key se crea cuando se inicia sesión
$_SESSION["timeout"] = time();

//Templo = 100 madera, 50 piedra, 50 oro
//Almacen = 150 madera, 25 piedra, 100 comida
//Cuartel = 75 madera, 25 piedra, 50 comida, 20 oro
//Aserradero = 200 madera, 50 de piedra
//Cantera de mármol = 200 piedra, 50 madera
//Huerto: 200 comida, 50 madera
//Mercado/recaudador: 50 madera, 50 piedra y 100 oro

//session_destroy(); 

//Reduciendo el oro(1 cada 5 segundos) y la comida (2 cada 5 segundos) 
if (isset($_SESSION["intervalo"])) {
	// Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	$sessionTTL2 = time() - $_SESSION["intervalo"];
	$num_decremento = $sessionTTL2 / 5;
	$_SESSION['suministros']['oro'] -= round($num_decremento);
	$_SESSION['suministros']['comida'] -= round($num_decremento * 2);
}

$_SESSION["intervalo"] = time();

//session_destroy();

//Stock inicial 2000 de cada
if (!isset($_SESSION['suministros'])) {
	//La primera vez, para crear la sesión
	$_SESSION['suministros'] = array();
	$_SESSION['suministros']['oro'] = 2000;
	$_SESSION['suministros']['madera'] = 2000;
	$_SESSION['suministros']['comida'] = 2000;
	$_SESSION['suministros']['marmol'] = 2000;

	$_SESSION['edificios'] = array();
	$_SESSION['edificios']['cuarteles'] = 0;
	$_SESSION['edificios']['templos'] = 0;
	//parte de bilal
	$_SESSION['edificios']['aserraderos'] = 0;
	$_SESSION['edificios']['canteras'] = 0;
	$_SESSION['edificios']['huertos'] = 0;
	$_SESSION['edificios']['mercados'] = 0;
}


$oro = $_SESSION['suministros']['oro'];
$madera = $_SESSION['suministros']['madera'];
$comida = $_SESSION['suministros']['comida'];
$marmol = $_SESSION['suministros']['marmol'];
$num_cuarteles = $_SESSION['edificios']['cuarteles'];
$num_templos = $_SESSION['edificios']['templos'];
$num_aserraderos = $_SESSION['edificios']['aserraderos'];
$num_canteras = $_SESSION['edificios']['canteras'];
$num_huertos = $_SESSION['edificios']['huertos'];
$num_mercados = $_SESSION['edificios']['mercados'];

//Reduciendo el oro(1 cada 5 segundos) y la comida (2 cada 5 segundos) 
if (isset($_SESSION["intervalo"])) {
	// Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	$sessionTTL2 = time() - $_SESSION["intervalo"];
	$tiempo_relativo = $sessionTTL2 / 5;

	//decrementar materias primas
	$_SESSION['suministros']['oro'] -= round($tiempo_relativo);
	$_SESSION['suministros']['comida'] -= round($tiempo_relativo * 2);

	// generar materia prima
	// Moví esto aquí porque usa la misma if y el $num_decremento que cambié a $tiempo_relativo para que tenga más sentido
	$_SESSION['suministros']['madera'] += round($tiempo_relativo * 10) * $num_aserraderos;
	$_SESSION['suministros']['marmol'] +=  round($tiempo_relativo * 10) * $num_canteras;
	$_SESSION['suministros']['comida'] +=  round($tiempo_relativo * 10) * $num_huertos;
	$_SESSION['suministros']['oro'] += round($tiempo_relativo * 2) * $num_mercados;
}

$_SESSION["intervalo"] = time();

//Construimos templo
if (isset($_POST['templo_x'])) {
	//Mirar si hay recursos
	if (($madera >= 100) && ($marmol >= 50) && ($oro >= 50)) {
		//A construir
		$_SESSION['edificios']['templos']++;
		$num_templos++;

		//Decrementar stock
		$_SESSION['suministros']['madera'] -= 100;
		$_SESSION['suministros']['marmol'] -= 50;
		$_SESSION['suministros']['oro'] -= 50;
	} else
		echo "<script> alert('No hay materia prima suficiente');</script>";
}
//Construimos cuartel
if (isset($_POST['cuartel_x'])) {
	//Mirar si hay recursos
	if (($madera >= 75) && ($marmol >= 25) && ($oro >= 20) && ($comida >= 50)) {
		//A construir
		$_SESSION['edificios']['cuarteles']++;
		$num_cuarteles++;

		//Decrementar stock
		$_SESSION['suministros']['madera'] -= 75;
		$_SESSION['suministros']['marmol'] -= 25;
		$_SESSION['suministros']['oro'] -= 20;
		$_SESSION['suministros']['comida'] -= 50;
	} else
		echo "<script> alert('No hay materia prima suficiente');</script>";
}

//Construimos aserradero
if (isset($_POST['aserradero_x'])) {
	//Mirar si hay recursos
	if (($madera >= 200) && ($marmol >= 50)) {
		//A construir
		$_SESSION['edificios']['aserraderos']++;
		$num_aserraderos++;

		//Decrementar stock
		$_SESSION['suministros']['madera'] -= 200;
		$_SESSION['suministros']['marmol'] -= 50;
	} else
		echo "<script> alert('No hay materia prima suficiente');</script>";
}

//Construimos cantera
if (isset($_POST['cantera_x'])) {
	//Mirar si hay recursos
	if (($madera >= 50) && ($marmol >= 200)) {
		//A construir
		$_SESSION['edificios']['canteras']++;
		$num_canteras++;

		//Decrementar stock
		$_SESSION['suministros']['madera'] -= 50;
		$_SESSION['suministros']['marmol'] -= 200;
	} else
		echo "<script> alert('No hay materia prima suficiente');</script>";
}

//Construimos huerto
if (isset($_POST['huerto_x'])) {
	//Mirar si hay recursos
	if (($madera >= 50) && ($comida >= 200)) {
		//A construir
		$_SESSION['edificios']['huertos']++;
		$num_huertos++;

		//Decrementar stock
		$_SESSION['suministros']['madera'] -= 50;
		$_SESSION['suministros']['comida'] -= 200;
	} else
		echo "<script> alert('No hay materia prima suficiente');</script>";
}

//Construimos mercado
if (isset($_POST['mercado_x'])) {
	//Mirar si hay recursos
	if (($madera >= 50) && ($marmol >= 50) && ($oro >= 100)) {
		//A construir
		$_SESSION['edificios']['mercados']++;
		$num_mercados++;

		//Decrementar stock
		$_SESSION['suministros']['madera'] -= 50;
		$_SESSION['suministros']['marmol'] -= 50;
		$_SESSION['suministros']['oro'] -= 100;
	} else
		echo "<script> alert('No hay materia prima suficiente');</script>";
}

// Producir materia prima 
// Por cada ASERRADERO 10 madera / 5 seg
$_SESSION['suministros']['madera'] += 10 * $num_aserraderos;

// Por cada CANTERA 10 marmol / 5 seg
$_SESSION['suministros']['marmol'] += 10 * $num_canteras;

// Por cada HUERTO 10 comida / 5 seg
$_SESSION['suministros']['comida'] += 10 * $num_huertos;

// Por cada MERCADO 2 oro / 5 seg
$_SESSION['suministros']['oro'] += 2 * $num_mercados;

?>
<div class="bg-gray-100 md:h-screen">
	<div class="px-4 py-8 flex flex-col md:flex-row h-full">
		<div class="md:w-1/2 lg:w-2/6 h-full flex flex-col justify-center items-center">
			<div class="flex flex-col items-center justify-self-start mb-16">
				<?php if ($successFlash) : ?>
					<div class="bg-green-200 rounded-md p-4">
						<?php echo $successFlash ?>
					</div>
				<?php endif; ?>
				<ul class="flex space-x-8">
					<li>
						<button class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-md font-semibold">Guardar Partida</button>
					</li>
					<li>
						<button class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-md font-semibold">Cargar Partida</button>
					</li>
				</ul>
				<a href="/" class="mt-6 bg-red-500 hover:bg-red-600 text-white p-2 rounded-md font-semibold">Quitar</a>
			</div>
			<form class="font-semibold flex flex-wrap justify-center items-center" action="/juegaciam" method="post">
				<div class="m-2 p-2 flex flex-col items-center">
					<input class="w-24 md:w-32 border-gray-400 border-2 hover:border-gray-600" type="image" src="imgs/crear_templo.gif" name="templo" value="templo">
					<label for="templo">Templo</label>
				</div>
				<div class="m-2 p-2 flex flex-col items-center">
					<input class="w-24 md:w-32 border-gray-400 border-2 hover:border-gray-600" type="image" src="imgs/crear_cuartel.gif" name="cuartel" value="cuartel">
					<label for="Cuartel">Cuartel</label>
				</div>
				<div class="m-2 p-2 flex flex-col items-center">
					<input class="w-24 md:w-32 border-gray-400 border-2 hover:border-gray-600" type="image" src="imgs/crear_aserradero.png" name="aserradero" value="aserradero">
					<label for="aserradero">Aserradero</label>
				</div>
				<div class="m-2 p-2 flex flex-col items-center">
					<input class="w-24 md:w-32  border-gray-400 border-2 hover:border-gray-600" type="image" src="imgs/crear_cantera.png" name="cantera" value="cantera">
					<label for="cantera">Cantera</label>
				</div>
				<div class="m-2 p-2 flex flex-col items-center">
					<input class="w-24 md:w-32  border-gray-400 border-2 hover:border-gray-600" type="image" src="imgs/crear_huerto.png" name="huerto" value="huerto">
					<label for="huerto">Huerto</label>
				</div>
				<div class="m-2 p-2 flex flex-col items-center">
					<input class="w-24 md:w-32  border-gray-400 border-2 hover:border-gray-600" type="image" src="imgs/crear_mercado.png" name="mercado" value="mercado">
					<label for="mercado">Mercado</label>
				</div>
			</form>
		</div>
		<div class="h-full w-1 m-4 bg-gray-300"></div>

		<div class="flex flex-col items-center flex-grow">
			<div class="flex flex-wrap  justify-around">
				<div class="m-2 p-2 flex items-center">
					<img class="w-8 mr-3" src="svgs/ingots.svg" alt="">
					<div id="oro" class="font-semibold">
						<?php print $_SESSION['suministros']['oro']; ?>
					</div>
				</div>
				<div class="m-2 p-2 flex flex items-center">
					<img class="w-8 mr-3" src="svgs/wood.svg" alt="">
					<div id="madera" class="font-semibold">
						<?php print $_SESSION['suministros']['madera']; ?>
					</div>
				</div>
				<div class="m-2 p-2 flex flex items-center">
					<img class="w-8 mr-3" src="svgs/food.svg" alt="">
					<div id="comida" class="font-semibold">
						<?php print $_SESSION['suministros']['comida']; ?>
					</div>
				</div>
				<div class="m-2 p-2 flex flex items-center">
					<img class="w-8 mr-3" src="svgs/marbles.svg" alt="">
					<div id="marmol" class="font-semibold">
						<?php print $_SESSION['suministros']['marmol']; ?>
					</div>
				</div>
			</div>

			<div class="flex font-semibold flex-wrap justify-around">
				<div class="m-2 p-2">
					<span class=""> Templos: </span>
					<span class=""> <?= $num_templos ?> </span>
				</div>
				<div class="m-2 p-2">
					<span class=""> Cuarteles: </span>
					<span class=""> <?= $num_cuarteles ?> </span>
				</div>
				<div class="m-2 p-2">
					<span class=""> Aserraderos: </span>
					<span class=""> <?= $num_aserraderos ?> </span>
				</div>
				<div class="m-2 p-2">
					<span class=""> Canteras: </span>
					<span class=""> <?= $num_canteras ?> </span>
				</div>
				<div class="m-2 p-2">
					<span class=""> Huertos: </span>
					<span class=""> <?= $num_huertos ?> </span>
				</div>
				<div class="m-2 p-2">
					<span class=""> Mercados: </span>
					<span class=""> <?= $num_mercados ?> </span>
				</div>
			</div>

			<div class="self-stretch flex-grow">
				<img class="object-contain mx-auto h-full" src="imgs/ikariam.png">
			</div>
		</div>
	</div>
</div>
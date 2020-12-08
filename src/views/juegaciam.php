<?php
//CABECERA DE HTML

header("Refresh:5 url=juegaciam");
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
		echo "<script> alert('No hay materia prima suficiente');</script>>";
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

<div id="juego" class="h-100">
	<div class="row align-items-center h-100">
		<div class="col-3">
			<form class="row justify-content-center mb-2" action="/juegaciam" method="post">
				<div class="col">
					<div class="crear-edificio">
						<label for="templo">Templo</label>
						<input type="image" src="imgs/crear_templo.gif" name="templo" value="templo">
					</div>
				</div>
				<div class="col">
					<div class="crear-edificio">
						<label for="Cuartel">Cuartel</label>
						<input type="image" src="imgs/crear_cuartel.gif" name="cuartel" value="cuartel">
					</div>
				</div>
				<div class="w-100 mb-3"></div>
				<div class="col">
					<div class="crear-edificio">
						<label for="aserradero">Aserradero</label>
						<input type="image" src="imgs/crear_aserradero.png" name="aserradero" value="aserradero">
					</div>
				</div>
				<div class="col">
					<div class="crear-edificio">
						<label for="cantera">Cantera</label>
						<input type="image" src="imgs/crear_cantera.png" name="cantera" value="cantera">
					</div>
				</div>
				<div class="w-100 mb-3"></div>
				<div class="col">
					<div class="crear-edificio">
						<label for="huerto">Huerto</label>
						<input type="image" src="imgs/crear_huerto.png" name="huerto" value="huerto">
					</div>
				</div>
				<div class="col">
					<div class="crear-edificio">
						<label for="mercado">Mercado</label>
						<input type="image" src="imgs/crear_mercado.png" name="mercado" value="mercado">
					</div>
				</div>
			</form>
		</div>
		<div class="col">
			<div class="row">
				<div class="col">
					<div class="row border-end border-2">
						<div class="col-4">
							<img style="width:2rem" src="svgs/ingots.svg" alt="">
						</div>
						<div id="oro" class="fs-5 col">
							<?php print $_SESSION['suministros']['oro']; ?>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row align-items-center mb-3 border-end border-2">
						<div class="col-4">
							<img style="width:2rem" src="svgs/wood.svg" alt="">
						</div>
						<div id="madera" class="fs-5 col">
							<?php print $_SESSION['suministros']['madera']; ?>
						</div>
					</div>
				</div>
				<div class="col">

					<div class="row align-items-center mb-3 border-end border-2">
						<div class="col-4">
							<img style="width:2rem" src="svgs/food.svg" alt="">
						</div>
						<div id="comida" class="fs-5 col">
							<?php print $_SESSION['suministros']['comida']; ?>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row align-items-center mb-3">
						<div class="col-4">
							<img style="width:2rem" src="svgs/marbles.svg" alt="">
						</div>
						<div id="marmol" class="fs-5 col">
							<?php print $_SESSION['suministros']['marmol']; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="row align-items-center border-end border-2">
						<div class="col">
							Templos:
						</div>
						<div class="fs-5 col">
							<?= $num_templos ?>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row align-items-center mb-3 border-end border-2">
						<div class="col">
							Cuarteles:
						</div>
						<div class="fs-5 col">
							<?= $num_cuarteles ?>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row align-items-center mb-3 border-end border-2">
						<div class="col">
							Aserraderos:
						</div>
						<div class="fs-5 col">
							<?= $num_aserraderos ?>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row align-items-center mb-3">
						<div class="col">
							Canteras:
						</div>
						<div class="fs-5 col">
							<?= $num_canteras ?>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row align-items-center mb-3">
						<div class="col">
							Huertos:
						</div>
						<div class="fs-5 col">
							<?= $num_huertos ?>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row align-items-center mb-3">
						<div class="col">
							Mercados:
						</div>
						<div class="fs-5 col">
							<?= $num_mercados ?>
						</div>
					</div>
				</div>
			</div>
			<div id="bg" class="row mb-2">
				<img src="imgs/ikariam.png">
			</div>
		</div>
	</div>
</div>
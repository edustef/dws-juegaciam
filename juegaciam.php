<link rel="stylesheet" href="css/style.css">
<?php
//CABECERA DE HTML
include('cabecera.php');

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

<div id="juego">
	<form class="sidebar" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<input class="crear-edificio" type="image" src="imgs/crear_templo.gif" name="templo" value="templo">
		<input class="crear-edificio" type="image" src="imgs/crear_cuartel.gif" name="cuartel" value="cuartel">
		<input class="crear-edificio" type="image" src="imgs/crear_aserradero.png" name="aserradero" value="aserradero">
		<input class="crear-edificio" type="image" src="imgs/crear_cantera.png" name="cantera" value="cantera">
		<input class="crear-edificio" type="image" src="imgs/crear_huerto.png" name="huerto" value="huerto">
		<input class="crear-edificio" type="image" src="imgs/crear_mercado.png" name="mercado" value="mercado">
	</form>
	<figure id="bg">
		<img src="imgs/ikariam.png">
	</figure>
	<section class="sidebar">
		<div class="recursos">
			<div>
				<h3 id="oro">ORO: <?php print $_SESSION['suministros']['oro']; ?></h3>
				<h3 id="madera">MADERA: <?php print $_SESSION['suministros']['madera']; ?></h3>
				<h3 id="comida">COMIDA: <?php print $_SESSION['suministros']['comida']; ?></h3>
				<h3 id="marmol">MARMOL: <?php print $_SESSION['suministros']['marmol']; ?></h3>
			</div>
			<?php
			echo '
			<div>
				<span>Templos:' . $num_templos . '</span>
				<span>Cuarteles:' . $num_cuarteles . '</span>
				<span>Aserraderos:' . $num_aserraderos . '</span>
				<span>Canteras:' . $num_canteras . '</span>
				<span>Huertos:' . $num_huertos . '</span>
				<span>Mercados:' . $num_mercados . '</span>
			</div>
			';
			?>
		</div>
	</section>



</div>
<?php
//PIE DE PÁGINA
include('pie.php');
?>
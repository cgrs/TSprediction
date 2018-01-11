<?php
// Fichero con funciones propias para el manejo de la aplicacion

// Funcion para mostrar una lista de samples con la siguiente estructura:
// [[60], [61], [62], [63], [65]]
function print_samples($samples) {
	foreach ($samples as /* $key => */ $value) {
		// pruebas
		echo $value[0]." | ";
	}

	echo "<br>";
}


// Funcion para mostrar una lista de targets con la siguiente estructura:
// [3.1, 3.6, 3.8, 4, 4.1]
function print_targets($targets) {
	foreach ($targets as /* $key => */ $value) {
		// pruebas
		echo $value." | ";
	}

	echo "<br>";
}

// funcion para grabar un array json en un fichero
// para enviarle el formato de archivo a jose ignacio
// el parametro log si esta activo nos muestra la confirmacion de que se ha grabado correctamente	
function grabar_array($array, $nom_file, $log=true) {
	$handle = fopen($nom_file, "w+");

	$mi_json = json_encode($array);
	$fwrite = fwrite($handle, $mi_json); // se graba el json en el fichero

	fclose($handle); // se cierra el fichero

	// se comprueba que se ha grabado correctamente
	if ($log) {
		if ($fwrite != false) {
			echo "Se han escrito ".$fwrite." bytes.<br>";
		} else {
			echo "ERROR, no se ha grabado correctamente <br>";
		}
	}

	return $fwrite;
}

// funcion para leer los datos del fichero json
function get_datos ($nom_file="datos.json") {
	$handle = fopen($nom_file, "r");

	$datos_json = fread($handle, filesize($nom_file));
	$datos = json_decode($datos_json, true);

	fclose($handle); // se cierra el fichero

	return $datos;
}

?>
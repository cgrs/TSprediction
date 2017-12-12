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
function grabar_array($array, $nom_file) {
	$handle = fopen($nom_file, "w+");

	$mi_json = json_encode($array);

	fclose($handle); // se cierra el fichero
}

?>
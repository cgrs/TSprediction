<?php

require_once 'funciones.php'; // se importan las funciones propias 
require_once 'vendor/autoload.php';

use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;

$num = 1000;
if (($fichero = fopen("data/data.csv", "r")) !== FALSE) {
    // Lee los nombres de los campos
    $nombres_campos = fgetcsv($fichero, 0, ",", "\"", "\"");
    $num_campos = count($nombres_campos);
    // Lee los registros
    $samples = [];
    $targets = [];
    for ($i = 0; $i < $num; $i++) {
    
    	$datos = fgetcsv($fichero, 0, ";");
    	array_push($samples, [$i+1]);
    	array_push($targets, $datos[4]);

    }

    $regression = new SVR(Kernel::LINEAR);
	$regression->train($samples, $targets);

	$result = $regression->predict([100]);

	//echo "Elementos: ";
	//print_targets($targets);
	//echo "Elemento a predecir: ".$predict."<br>";
	echo "Resultado (predice el siguiente): ".$result;
}

?>
<?php

require_once 'funciones.php'; // se importan las funciones propias 
require_once 'vendor/autoload.php';

use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;

// recogida de datos
// $arr = array('Fich' => "data.csv", 'Pre' => 12122012, 'PosV' => 5, 'PosT' => 0); // formato de la variable de datos que va a llegar por curl
$data = json_decode(file_get_contents('php://input'));
//$data['Fich'] = 'data.csv'; // solo para pruebas, cuando funcione el esb comentar
$ruta_datos = dirname(dirname(__FILE__)).'/data/'.$data['Fich'];
$num = $data['num'];
//$num = 2000; // solo para pruebas, comentar cuando funcione el esb
//var_dump($ruta_datos);
var_dump($data);
if (($fichero = fopen($ruta_datos, "r")) !== FALSE) {
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

	$result = $regression->predict([$num+1]);

	//echo "Elementos: ";
	//print_targets($targets);
	//echo "Elemento a predecir: ".$predict."<br>";
	echo "Resultado (predice el siguiente): ".$result;
}

?>
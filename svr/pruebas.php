<?php

require_once 'funciones.php'; // se importan las funciones propias 
require_once 'vendor/autoload.php';

use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;

// echo "OPCIONES<br>";
// echo "<hr>";

// $samples = [[60], [61], [62], [63], [65]]; // muestras
// $targets = [3.1, 3.6, 3.8, 4, 4.1];		   // objetivos
$datos = get_datos();
$samples = $datos['samples'];
$targets = $datos['targets'];
$predict = 66;	// elemento a predecir

$regression = new SVR(Kernel::LINEAR);
$regression->train($samples, $targets);

$result = $regression->predict([$predict]);

echo "<h1>Resultados:</h1>";
echo "Samples: ";
print_samples($samples);
echo "Targets: ";
print_targets($targets);
echo "Elemento a predecir: ".$predict."<br>";
echo "Resultado: ".$result;
echo "<hr>";

$mis_datos = ['samples' => $samples, 'targets' => $targets];
// echo json_encode($targets);
// echo json_encode($samples);
// echo json_encode($datos);

// Se graban los datos en un fichero .json
//grabar_array($mis_datos, "datos.json");

?>
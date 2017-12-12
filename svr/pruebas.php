<?php

require_once 'funciones.php'; // se importan las funciones propias 
require_once 'vendor/autoload.php';

use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;

$samples = [[60], [61], [62], [63], [65]]; // muestras
$targets = [3.1, 3.6, 3.8, 4, 4.1];		   // objetivos
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

echo json_encode($targets);
echo json_encode($samples);

?>
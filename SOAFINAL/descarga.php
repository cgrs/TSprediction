<?php

$v1 = $_GET['var'];

if($v1==1)
 {
	$file ="archivos/fichero1.txt"; 
	$filename = "fichero1.txt"; // el nombre con el que se descargara, puede ser diferente al original 
 }
else if ($v1==2)
 {
	$file ="archivos/fichero2.txt"; 
	$filename = "fichero2.txt"; // el nombre con el que se descargara, puede ser diferente al original 
 }
else if($v1==3)
 {
	$file ="archivos/fichero3.txt"; 
	$filename = "fichero3.txt"; // el nombre con el que se descargara, puede ser diferente al original 
 }


header("Content-type: application/octet-stream"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=\"$filename\"\n"); 
readfile($file); 
?>
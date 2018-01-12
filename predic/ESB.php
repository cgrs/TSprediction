<?php
//recibimos los datos y los guardamos en una variable
$datos = json_decode(file_get_contents('php://input'));

//var_dump ($datos);

	// con este curl al puerto 9999 me comunico con el algoritmo MR programado en GO
	$handle = curl_init("localhost:9999");
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($datos));
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	$response=curl_exec($handle);
	curl_close($handle);

	// por el puerto 5000 me comunico con el algoritmo prophet, programado en Python
	$handle = curl_init("localhost:5000");
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($datos));
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	$response2=curl_exec($handle);
	curl_close($handle);
	
	$response2 = json_decode($response2);

	// me comunico con el algoritmo svr programado en php
	$handle = curl_init("http://localhost/TSpredict/predic/svr/index.php");
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($datos));
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	$response3=curl_exec($handle);
	curl_close($handle);


    $nombre_archivo = "data/MR.txt"; 
	
    if(file_exists($nombre_archivo))
    {
        $mensaje = "Nueva predicción realizada:";
    }
 
    else
    {
        $mensaje = "Se ha realizado la primera predicción con LS:";
    }
 
    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo, date("d m Y H:m:s"). $mensaje.$response."\n"))
        {
            echo "MR se ha ejecutado correctamente";
			echo "<br>";
        }
        else
        {
            echo "Ha habido un problema al crear o abrir el archivo de MR";
			echo "<br>";
        }
 
        fclose($archivo);
    }
	
    $nombre_archivo = "data/svr.txt"; 
	
    if(file_exists($nombre_archivo))
    {
        $mensaje = "Nueva predicción realizada:";
    }
 
    else
    {
        $mensaje = "Se ha realizado la primera predicción con SVR:";
    }
 
    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo, date("d m Y H:m:s"). $mensaje.$response3."\n"))
        {
            echo "SVR se ha ejecutado correctamente";
			echo "<br>";
        }
        else
        {
            echo "Ha habido un problema al crear o abrir el archivo de SRV";
			echo "<br>";
        }
 
        fclose($archivo);
    }

    $nombre_archivo = "data/prophet.txt"; 
	
    if(file_exists($nombre_archivo))
    {
        $mensaje = "Nueva predicción realizada:";
    }
 
    else
    {
        $mensaje = "Se ha realizado la primera predicción con Prophet:";
    }
 
    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo, date("d m Y H:m:s"). $mensaje.$response2."\n"))
        {
            echo "Prophet se ha ejecutado correctamente";
			echo "<br>";
        }
        else
        {
            echo "Ha habido un problema al crear o abrir el archivo de prophet";
			echo "<br>";
        }
 
        fclose($archivo);
    }

?>
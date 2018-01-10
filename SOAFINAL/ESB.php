<?php
//recibimos los datos y los guardamos en una variable
$datos = file_get_contents('php://input');

	
$handle = curl_init("http://localhost/SOAFINAL/MR.php");
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $datos);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$response=curl_exec($handle);
curl_close($handle);

    $nombre_archivo = "data/mr.txt"; 
	
    if(file_exists($nombre_archivo))
    {
        $mensaje = "Nueva predicción realizada:";
    }
 
    else
    {
        $mensaje = "Se ha realizado la primera predicción con MR:";
    }
 
    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo, date("d m Y H:m:s"). $mensaje.$response."\n"))
        {
            echo "Se ha ejecutado correctamente";
        }
        else
        {
            echo "Ha habido un problema al crear o abrir el archivo";
        }
 
        fclose($archivo);
    }
 
?>
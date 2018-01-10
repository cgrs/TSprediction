<?php
//recibimos los datos y los guardamos en una variable
 $data = json_decode(file_get_contents('php://input'));
 

	$handle = curl_init("localhost:9999");
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	$response=curl_exec($handle);
	curl_close($handle);
	
	?></br><?php
	
	echo $response;
?>
<?php

$arr = array('Fich' => "data.csv", 'Pre' => "12/12/2012", 'PosV' => 5, 'PosT' => 0);

echo json_encode($arr);

	$handle = curl_init("localhost:9999");
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($arr));
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	$response=curl_exec($handle);
	curl_close($handle);
	
	?></br><?php
	
	echo $response;
?>
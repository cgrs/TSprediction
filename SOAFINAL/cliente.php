<!DOCTYPE html>
<html lang="es">
  <head>
	<meta charset="utf-8" />
	<title>predicción automática de series temporales</title>
	<link rel="stylesheet" type="text/css" href="cliente.css">
  </head>
  <body>
<div id="todo">
<div id="casitodo">


	<div id="todos">
		<h1>Predicción automática de series temporales</h1>
		<p>Se ha realizado la carga de un archivo:</p>
		

		<?php
			if ($_FILES['archivo']["error"] > 0) 
			  {
				echo "Error: " . $_FILES['archivo']['error'] . "<br>";
			  }
			else
			  {
				
				echo "Usted ha subido el siguiente archivo:";
				echo $_FILES['archivo']['name'] . "<br>";

				/*
				echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
				echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
				echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
				echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
				*/
				/*ahora con la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
				if (!strcmp($_FILES['archivo']['type'],"application/vnd.ms-excel"))
				{
					move_uploaded_file($_FILES['archivo']['tmp_name'],"data/" . $_FILES['archivo']['name']);
				}
				else
				{
					echo "ERROR: El archivo que subió no era un CSV";
				}
			  }
			  
			if (isset($_FILES['archivo']['name']))
			{
				$data = $_FILES['archivo']['name']; 
			
				$handle = curl_init("http://localhost/SOAFINAL/ESB.php");
				curl_setopt($handle, CURLOPT_POST, true);
				curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				$response=curl_exec($handle);
				curl_close($handle);

				echo $response;
			}
		?>
				
		<p>A continuación podrá descargar en archivo .txt la predicción realizada por los algoritmos.</p>
	</div>

	<div id="svr">
		<h2>SVR</h2>
		<p>aquí puede descargar su archivo con la predicción del algoritmo SVR</p>
		<a class="boton_personalizado" href="descarga.php?var=1" >Predicción SVR</a>
	</div>

	<div id="mr">
		<h2>MR</h2>
		<p>aquí puede descargar su archivo con la predicción del algoritmo MR</p>
		<a class="boton_personalizado" href="descarga.php?var=2" >Predicción MR</a>
	</div>

	<div id="arima">
		<h2>Modelo autorregresivo integrado de media móvil</h2>
		<p>aquí puede descargar su archivo con la predicción del algoritmo ARIMA</p>
		<a class="boton_personalizado" href="descarga.php?var=3" >Predicción ARIMA</a>
	</div>
	<div id="barritanegra">
	<br>
	</div>
	<div style="clear: both">
		<p>Enlaces de obtención de los algoritmos: </p>
		<p><a href="https://php-ml.readthedocs.io/en/latest/machine-learning/regression/svr/">SVR</a></p>
		<p><a href="www.wikipedia.org">MR</a></p>
			<p><a href="http://www.statsmodels.org/stable/generated/statsmodels.tsa.arima_model.ARIMA.html#statsmodels.tsa.arima_model.ARIMA">ARIMA</a></p>
		<p>Realizado por Aarón Portales, Carlos González, Pablo García y José Ignacio Mayoral</p>
	</div>
</div>
<br>
</div>
 </body>
</html>
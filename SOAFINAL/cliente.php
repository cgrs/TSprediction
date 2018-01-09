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
		<p>Esta aplicación permite cargar un fichero con series temporales para luego poder predecir cómo continúa la misma.</p>
		<p>Para poder utilizarla cargue un fichero en esta sección:</p>
		

		<?php
			if ($_FILES['archivo']["error"] > 0) 
			  {
				echo "Error: " . $_FILES['archivo']['error'] . "<br>";
			  }
			else
			  {
				/*  
				echo "Usted ha subido el siguiente archivo con las siguientes características:";
				echo "Nombre: " . $_FILES['archivo']['name'] . "<br>";
				echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
				echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
				echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
				*/
				/*ahora con la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
				move_uploaded_file($_FILES['archivo']['tmp_name'],"archivos/" . $_FILES['archivo']['name']);	
			  }
		?>
				
		<p>A continuación podrá descargar un fichero con la predicción estimada según los algoritmos.</p>
	</div>

	<div id="Aaron">
		<h2>Nombre del algoritmo de Aarón</h2>
		<p>aquí puede descargar su archivo con la predicción de Aarón</p>
		<a class="boton_personalizado" href="descarga.php?var=1" >Descargar</a>
	</div>

	<div id="Pablo">
		<h2>Nombre del algoritmo de Pablo</h2>
		<p>aquí puede descargar su archivo con la predicción de Pablo</p>
		<a class="boton_personalizado" href="descarga.php?var=2" >Descargar</a>
	</div>

	<div id="Carlos">
		<h2>Nombre del algoritmo de Carlos</h2>
		<p>aquí puede descargar su archivo con la predicción de Carlos</p>
		<a class="boton_personalizado" href="descarga.php?var=3" >Descargar</a>
	</div>
	<div id="barritanegra">
	<br>
	</div>
	<div style="clear: both">
		<p>Algoritmos obtenidos en: </p>
		<p><a href="www.wikipedia.org">Wikipedia</a></p>
		<p><a href="www.wikipedia.org">Wikipedia</a></p>
		<p><a href="www.wikipedia.org">Wikipedia</a></p>
		<p>Realizado por Aarón Portales, Carlos González, Pablo García y José Ignacio Mayoral</p>
	</div>
</div>
<br>
</div>
 </body>
</html>
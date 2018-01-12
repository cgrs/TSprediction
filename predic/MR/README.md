El socket escucha en el puerto 9999 y recibe json con el siguiente formato:

('Fich' => "data.csv", 'Pre' => "12/12/2012", 'PosV' => 5, 'PosT' => 0);

Fich es el fichero donde se encuentran los datos, un CSV separado por ';' y con '#' los comentarios.  
Pre es la fecha en la cual se quiere predecir con formato dd/mm/aaaa.  
PosV es la posición de la variable a analizar en el csv, en los datos ejemplo, el voltaje.  
PostT es la posición de la variable en la que se encuentra el tiempo, debe de tener formato dd/mm/aaaa.
package main

//Librerías
import (
	"encoding/csv"
	"fmt"
	"log"
	"os"
	"github.com/sajari/regression"
	"strings"
	"strconv"
	"net/http"
	"encoding/json"
)

//Cambiar un string con la fecha a float ddmmaaaa
func formatearFecha(time string) float64{
	array := strings.Split(time,"/")	
	
	d:= array[0]
	m:= array[1]
	a:= array[2]
	
	varia:= d + m + a
	
	fecha,err:=strconv.ParseFloat(varia,64)
	if err!=nil{
		fmt.Println("Error en la conversión")
		log.Fatal(err)
	}
	
	return fecha
}

//Estructura para el mensaje recibido en formato json
type Message struct {
	Fich string	`json:"Fich"`
	Pre string	`json:"Pre"`
	PosT int `json:PosT`
	PosV int `json:PosV`
	//CsvC rune `json:CsvC`
	//CsvS rune `json:CsvS`
}

func main() {
	//Función para crear socket
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		//Variable de la estructura creada
		var u Message
		
		//Decodificar el json
		err := json.NewDecoder(r.Body).Decode(&u)
		if err != nil {
			http.Error(w, err.Error(), 400)
			return
		}
		
		
		/*
		//Mostrar los datos de json
		fmt.Println(u.Fich)
		fmt.Println(u.Pre)
		fmt.Println(u.PosV)
		fmt.Println(u.PosT)
		//fmt.Println(u.CsvC)
		//fmt.Println(u.CsvS)
		*/
		
		//Creada el modelo de la regresión multivariable
		reg := new(regression.Regression)
		reg.SetObserved("Series temporales")
		reg.SetVar(0, "Tiempo")
		
		//Comprobaciones de variables
		if u.Pre!="" && u.PosV>=0 && u.PosT>=0 && u.Fich!="" {
			
			//Path de los datos
			dir:="../data/" + u.Fich
			
			//Abrir fichero
			file, err := os.Open(dir)
			if err!=nil{
				log.Fatal(err)
			}
			//Cerrar el fichero al final del programa
			defer file.Close()
			
			//Preparar para leer el csv con ; de separación y # de comentarios.
			fich := csv.NewReader(file)
			fich.Comma = ';'
			fich.Comment = '#'

			//Leer el csv
			records, err := fich.ReadAll()
			if err != nil {
				log.Fatal(err)
			}

			//fmt.Print(records)
			
			//Bucle for para leer e iterar sobre los datos
			for _,record := range records {
			
				//Coger el tiempo del registro
				time := record[u.PosT]
				
				//Coger el voltaje del registro
				voltaje,err := strconv.ParseFloat(record[u.PosV],64)
				if err!=nil{
					fmt.Println("Error en voltaje:")
					fmt.Println(record[u.PosV])
					log.Fatal(err)
				}
				
				//Cambiando el formato del tiempo
				fecha:=formatearFecha(time)
					
				//Entrenar el modelo
				reg.Train(
					regression.DataPoint(voltaje, []float64{fecha}),
				)

				//fmt.Println("Fecha",time,"Voltaje:",value)
				//fmt.Println(varia)
			}
			fmt.Println("Todos los Datos procesados.")
			
			//Correr el modelo
			reg.Run()
			
			//Cambiamos de string a float64 y quitamos "/" de la fecha
			prede:=formatearFecha(u.Pre)
			
			//Predicción pasada
			prediction, err := reg.Predict([]float64{prede})
			if err!=nil{
				log.Fatal(err)
			}
			
			//fmt.Println("La predicción para el tiempo elegido es: ",prediction)
			
			fmt.Fprintln(w, prediction)
			
		}else{
			
			fmt.Println("Error con los datos pasados.")
			
		}
	})
	//Puerto en el que se encuentra el socket
	log.Fatal(http.ListenAndServe(":9999", nil))
}
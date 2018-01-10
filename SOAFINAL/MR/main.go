package main

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

type Message struct {
	Fich string	`json:"Fich"`
	Pre float64	`json:"Pre"`
	PosT int `json:PosT`
	PosV int `json:PosV`
	//CsvC rune `json:CsvC`
	//CsvS rune `json:CsvS`
}

func main() {
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		
		var u Message
		
		err := json.NewDecoder(r.Body).Decode(&u)
		if err != nil {
			http.Error(w, err.Error(), 400)
			return
		}
		
		/*
		fmt.Println(u.Fich)
		fmt.Println(u.Pre)
		fmt.Println(u.PosV)
		fmt.Println(u.PosT)
		//fmt.Println(u.CsvC)
		//fmt.Println(u.CsvS)
		*/
		
		reg := new(regression.Regression)
		reg.SetObserved("Series temporales")
		reg.SetVar(0, "Tiempo")
		
		if u.Pre>=0 && u.PosV>=0 && u.PosT>=0 && u.Fich!="" {
			
			var fecha float64
			
			dir:="../data/" + u.Fich
			
			file, err := os.Open(dir)
			if err!=nil{
				log.Fatal(err)
			}
			defer file.Close()
			
			fich := csv.NewReader(file)
			fich.Comma = ';'
			fich.Comment = '#'

			records, err := fich.ReadAll()
			if err != nil {
				log.Fatal(err)
			}

			//fmt.Print(records)
			
			for i,record := range records {
			
				time := record[u.PosT]
				
				voltaje,err := strconv.ParseFloat(record[u.PosV],64)
				if err!=nil{
					fmt.Println("Error en voltaje:")
					fmt.Println(record[u.PosV])
					log.Fatal(err)
				}
				
				if i%160000==159999{
					fmt.Println(i,"Datos Procesados")
				}
				
				array := strings.Split(time,"/")		
				
				d:= array[0]
				m:= array[1]
				a:= array[2]
				
				varia:= d + m + a
				
				fecha,err=strconv.ParseFloat(varia,64)
				if err!=nil{
					fmt.Println("Error en la conversión")
					log.Fatal(err)
				}
					
				reg.Train(
					regression.DataPoint(voltaje, []float64{fecha}),
				)

				//fmt.Println("Fecha",time,"Voltaje:",value)
				//fmt.Println(varia)
			}
			fmt.Println("Datos procesados")
			
			reg.Run()
			
			prediction, err := reg.Predict([]float64{u.Pre})
			if err!=nil{
				log.Fatal(err)
			}
			
			fmt.Println("La predicción para el tiempo elegido es: ",prediction)
			
			fmt.Fprintln(w, prediction)
			
		}else{
			
			fmt.Println("Error con los datos pasados.")
			
		}
	})
	log.Fatal(http.ListenAndServe(":9999", nil))
}
package main

import (
	"encoding/csv"
	"fmt"
	"log"
	"os"
	"github.com/sajari/regression"
	"strings"
	"strconv"
)

func main() {
	reg := new(regression.Regression)
	reg.SetObserved("Murders per annum per 1,000,000 inhabitants")
	reg.SetVar(0, "Día")
	reg.SetVar(1, "Mes")
	reg.SetVar(2, "Año")
	
	file, err := os.Open("data.txt")
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
	
		time := record[0]
		
		voltaje,err := strconv.ParseFloat(record[5],64)
		if err!=nil{
			fmt.Println("Error en voltaje:")
			fmt.Println(record[5])
			log.Fatal(err)
		}
		
		if i%160000==159999{
			fmt.Println(i,"Datos Procesados")
			//reg.AddCross(PowCross(0, 2))
		}
		
		array := strings.Split(time,"/")
		
		d,err:= strconv.ParseFloat(array[0],64)
		if err!=nil{
			fmt.Println("Error en d")
			log.Fatal(err)
		}
		m,err:= strconv.ParseFloat(array[1],64)
		if err!=nil{
			fmt.Println("Error en m")
			log.Fatal(err)
		}
		a,err:= strconv.ParseFloat(array[2],64)
		if err!=nil{
			fmt.Println("Error en a")
			log.Fatal(err)
		}
			
		reg.Train(
			regression.DataPoint(voltaje, []float64{d,m,a}),
		)

		//fmt.Println("Fecha",time,"Voltaje:",value)
	}
	fmt.Println("Todos los datos han sido procesados entrenando a la máquina:")
	reg.Run()
	
	prediction1, err := reg.Predict([]float64{22, 6, 2007})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(prediction1)
	
		prediction2, err := reg.Predict([]float64{3, 1, 1999})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(prediction2)
	
		prediction3, err := reg.Predict([]float64{1, 7, 2012})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(prediction3)
	
		prediction4, err := reg.Predict([]float64{22, 11, 2017})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(prediction4)
	
}

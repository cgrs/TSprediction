package main

import (
	"encoding/csv"
	"fmt"
	"log"
	"os"
	"github.com/sajari/regression"
	"strings"
	"strconv"
	"math"
)

func main() {
	reg := new(regression.Regression)
	reg.SetObserved("Voltaje consumido diario")
	reg.SetVar(0, "fecha")
	
	var fecha float64
	
	file, err := os.Open("../data/data.csv")
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
	}
	fmt.Println("Datos procesados")
	
	reg.Run()
	
	prediction1, err := reg.Predict([]float64{12122009})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(math.Abs(prediction1))
	
		prediction2, err := reg.Predict([]float64{12122012})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(math.Abs(prediction2))
	
		prediction3, err := reg.Predict([]float64{112014})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(math.Abs(prediction3))
	
		prediction4, err := reg.Predict([]float64{12132015})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(math.Abs(prediction4))
	
	prediction5, err := reg.Predict([]float64{672017})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(math.Abs(prediction5))
	
	prediction6, err := reg.Predict([]float64{442019})
	if err!=nil{
		log.Fatal(err)
	}
	
	fmt.Println(math.Abs(prediction6))
	
}
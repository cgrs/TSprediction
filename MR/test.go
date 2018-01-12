package main

import (
	"fmt"
	"log"
	"strings"
	"strconv"
)

type Message struct {
	Fich string	`json:"Fich"`
	Pre float64	`json:"Pre"`
	PosT int `json:PosT`
	PosV int `json:PosV`
	//CsvC rune `json:CsvC`
	//CsvS rune `json:CsvS`
}

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

func main() {
	a:=formatearFecha("7/8/2012")
	
	fmt.Println(a)
}
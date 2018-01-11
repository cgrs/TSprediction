# Previsión de series temporales en Python

## Introducción

En este ejercicio se lleva a cabo una labor de análisis e interpretación de datos ordenados temporalmente. Dicho análisis culmina en la obtención de un modelo computerizado por el que poder predecir (con un cierto margen) futuras observaciones a partir de los datos existentes.

## Librerías utilizadas

* [Prophet](https://facebook.github.io/prophet/) (`fbprophet-0.2.1`)
* [Pandas](https://pandas.pydata.org/) (`pandas-0.21.0`)
* [Flask](http://flask.pocoo.org/) (`flask-0.12.2`)

## Enfoque utilizado

Después de haber investigado sobre diversos métodos de previsión de series temporales, el más sencillo de implementar ha sido usando `prophet`, una librería de Facebook enfocada al análisis de este tipo de datos.

### Procedimiento

1. Obtención de datos y su interpretación mediante `pandas`.
2. Análisis de los datos y creación de un modelo de previsión mediante `prophet`.
3. Creación de un pronóstico en un entorno cercano a la fecha a estimar (por lo menos de un mes)

## Aclaraciones

En el [conjunto de datos utilizado][dataset] la unidad mínima representada es el minuto, pero dadas las circunstancias del modelo de predicción utilizado, se ha tenido que remuestrear el conjunto para su uso con el día como la unidad mínima, obteniendo así una mejora en la velocidad.

## Referencias
Set de datos: [Individual household electric power consumption][dataset]

## Bibliografía

* https://facebook.github.io/prophet/docs/quick_start.html
* http://pandas.pydata.org/pandas-docs/stable/timeseries.html
* https://www.analyticsvidhya.com/blog/2016/02/time-series-forecasting-codes-python/
* https://www.digitalocean.com/community/tutorials/a-guide-to-time-series-forecasting-with-prophet-in-python-3
* https://machinelearningmastery.com/autoregression-models-time-series-forecasting-python/
* http://www.statsmodels.org/stable/generated/statsmodels.tsa.arima_model.ARIMA.html
* http://scikit-learn.org/stable/documentation.html
* https://mapr.com/blog/deep-learning-tensorflow/
* https://eu.udacity.com/course/intro-to-machine-learning--ud120

[dataset]: http://archive.ics.uci.edu/ml/datasets/Individual+household+electric+power+consumption
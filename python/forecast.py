'''
   Predicción de series temporales utilizando aprendizaje automático
   Datos de entrenamiento: http://archive.ics.uci.edu/ml/datasets/Individual+household+electric+power+consumption
'''
import os
import sys
from pathlib import Path
from time import time
from urllib.parse import urlparse
import pandas as pd
from fbprophet import Prophet
from log_supressor import suppress_stdout_stderr


def parsedate(date):
    return pd.datetime.strptime(date, '%d/%m/%Y')


def parse_csv(file_or_url):
    '''Genera un archivo de datos Pickle para su posterior uso.

    Dado que la cantidad de datos es alta, la lectura de los mismos
    ralentizaría la ejecución de este programa, por lo que se genera
    este archivo que incrementa la velocidad de acceso a los datos.
    '''
    uri = urlparse(file_or_url)
    file = os.path.basename(uri.path)
    print('finding cached dataframe...')
    pickle_file = os.path.splitext(file)[0] + '.pkl.gz'
    if Path('cache/' + pickle_file).is_file():
        print('found: using %s as data source' % pickle_file)
        return pd.read_pickle('cache/' + pickle_file)
    else:
        print('not found: parsing csv...')
        parsedate = lambda dates: pd.datetime.strptime(dates, '%d/%m/%Y %H:%M:%S')
        parsed_dataframe = pd.read_csv(
            file_or_url,
            delimiter=';',
            parse_dates=[['Date', 'Time']],
            date_parser=parsedate,
            index_col=['Date_Time'])
        print('generating cached dataframe...')
        parsed_dataframe.to_pickle('cache/' + pickle_file)
        return parsed_dataframe


def train(data, feature='Voltage'):
    '''Entrena al modelo contra una característica determinada y lo devuelve'''
    data = data.rename(columns={feature: 'y'})
    data['ds'] = data.index
    model = Prophet(interval_width=0.95)
    with suppress_stdout_stderr():
        model.fit(data)
    return model


def predict(csv_file, feature, date):
    '''Función principal'''
    t0 = time()
    ts = parse_csv(csv_file)
    print("csv parsing time: %dms" % round((time() - t0) * 1000))
    t0 = time()
    model = train(ts.resample('D').mean(), feature)
    print("training time: %dms" % round((time() - t0) * 1000))
    dayselapsed = (date.date() - ts.index[-1].to_pydatetime().date()).days
    t0 = time()
    # generar un abanico de datos por lo menos un mes más amplio que la fecha a predecir
    future = model.make_future_dataframe(periods=dayselapsed + 30)
    print("dataframe creation: %dms" % round((time() - t0) * 1000))
    t0 = time()
    forecast = model.predict(future)
    print("prediction time: %dms" % round((time() - t0) * 1000))
    estimated = forecast[['ds', 'yhat', 'yhat_lower',
                          'yhat_upper']].loc[forecast['ds'] == date]
    estimated = estimated.rename(
        columns={
            'yhat': 'estimated_value',
            'yhat_upper': 'upper_limit',
            'yhat_lower': 'lower_limit'
        })
    estimated = estimated.set_index('ds')
    return estimated.to_json(orient='index', date_format='iso')

def main():
    predict('household_power_consumption.txt', 'Voltage', parsedate(
        sys.argv[1]))


if __name__ == '__main__':
    main()

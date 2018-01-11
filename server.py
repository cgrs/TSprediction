from forecast import predict, parsedate
from flask import Flask, request, Response, json, jsonify, abort

app = Flask(__name__)


@app.route('/', methods=['GET', 'POST'])
def main():
    if request.method == 'POST':
        if not request.headers.get('content-type') == 'application/json':
            return jsonify({'message': 'bad request'}), 400
        if not request.data:
            return jsonify({'message': 'bad request'}), 400
        params = json.loads(request.data)
        if not 'file_or_url' in params:
            return jsonify({'message': 'bad request'}), 400
        if not 'feature' in params:
            return jsonify({'message': 'bad request'}), 400
        if not 'date' in params:
            return jsonify({'message': 'bad request'}), 400
        date = None
        try:
            date = parsedate(params['date'])
        except ValueError:
            return jsonify({'message': 'error parsing date'}), 400

        res = predict(params['file_or_url'], params['feature'], date)
        return Response(res, mimetype="application/json")
    else:
        return jsonify({
            'inputs': [{
                'file_or_url': 'archivo o URL a recoger por el programa'
            }, {
                'date': 'fecha a predecir'
            }, {
                'feature': 'nombre de la característica a predecir'
            }],
            'outputs': [{
                'date': 'fecha a predecir'
            }, {
                'estimated_value': 'valor estimado'
            }, {
                'upper_limit': 'límite superior'
            }, {
                'lower_limit': 'límite inferior'
            }]
        })


if __name__ == '__main__':
    app.run()

# -*- coding:utf-8 -*-

from bottle import route, run, HTTPResponse, request, Bottle, response, static_file
import simplejson as json
from StringIO import StringIO
import svm_predict as s

app = Bottle()

#@app.route('/', method="GET")
#def tmp():
#    return "TEST!!!"

@app.route('/svm', method="GET")
def svm():
    idfValue    = str(request.query["idf-value"])
    knownList   = request.query["known-list"]
    unknownList = request.query["unknown-list"]
#    print type(knownList)
#    return "|>"+idfValue+":"+float(knownList)
    #パラメータを型を変更して読み込む　でぐぐってみる
    return s.svm( knownList, unknownList, idfValue )
    

run(app,host='0.0.0.0', port=9900, debug=True, reloader=True) # ビルドインサーバの実行

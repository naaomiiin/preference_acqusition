# -*- coding:utf-8 -*-

from bottle import route, run, HTTPResponse, request, Bottle, response, static_file
import simplejson as json
from StringIO import StringIO
import svm_predict as s
import ast


app = Bottle()

#@app.route('/', method="GET")
#def tmp():
#    return "TEST!!!"

@app.route('/svm', method="GET")
def svm():
    idfValue    = str(request.query["idf-value"])
    knownString   = request.query["known-list"]
    knownList = []
    for idf in knownString.split(","):
        idf = float(idf)
        knownList.append([idf])
#   knownList = ast.literal_eval(knownList)
    unknownString = request.query["unknown-list"]
#   unknownList = ast.literal_eval(unknownList)
    unknownList =[]
    for idf in unknownString.split(","):
        idf = float(idf)
        unknownList.append([idf])
    #print type(knownList)
#    return "|>"+idfValue+":"+float(knownList)
    #パラメータを型を変更して読み込む　でぐぐってみる
    return str(s.svm( knownList, unknownList, idfValue ))


run(app,host='0.0.0.0', port=9900, debug=True, reloader=True) # ビルドインサーバの実行

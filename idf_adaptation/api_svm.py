# -*- coding:utf-8 -*-
from bottle import route, run, HTTPResponse, request, Bottle, response, static_file
import simplejson as json
import datetime
from StringIO import StringIO

app = Bottle()

@app.route('/')
@app.route('/<name>')
def hello(name = "unknownさん"):
    return "こんにちは！" + name


run(app,host='0.0.0.0', port=9900, debug=True, reloader=True)

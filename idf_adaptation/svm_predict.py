# -*- coding:utf-8 -*-

from sklearn.svm import LinearSVC
import numpy as np

def svm(knownList,unknownList,idfValue):
    # 学習データ
    print str(knownList)+" => "+str(unknownList)+" => "+str(idfValue)
#    for x in knownList:
    print len(knownList)
#    print ">>>"+len(knownList)
#known,unknown配列個数変数に入れる



# 1 for x in range(10) 1が10回表示される

#    data_training = [[x[1]] for x in data_training_tmp] # IDF値
#    label_training = [int(x[0]) for x in data_training_tmp] # わかる(1), わからない(0)
    
    # 試験データ
#data_test = 3.521

   
# 学習
 #   estimator = LinearSVC(C=1.0)  # モデルを定義
 #   estimator.fit(data_training, label_training)  # fit関数を使って教師データからパラメータを推定
    
# 予測
  #  label_prediction = estimator.predict()
  #  if label_prediction == [1]:
  #      return data_test + "はわかる"
  #  else:
  #      return data_test + "はわからない"


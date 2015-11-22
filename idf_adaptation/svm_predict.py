# -*- coding:utf-8 -*-

from sklearn.svm import LinearSVC
import numpy as np
import sys

def svm(knownList,unknownList,idfValue):

# 学習データ
    knownList_count = len(knownList)
    unknownList_count = len(unknownList)
    #print "わかるIDF個数>>>", knownList_count , ", わからないIDF個数>>>" , unknownList_count

    idfValue = float(idfValue)
    print type(idfValue)

    data_training = knownList + unknownList   # IDF値結合
    print data_training
    
    knownArray = []
    for i in range(knownList_count):     # "1" わかるIDF個数回表示
        knownArray.append(1)
    
    unknownArray = []
    for i in range(unknownList_count):     # "0" わからないIDF個数回表示                                                                                                            
        unknownArray.append(0)

    label_training = knownArray + unknownArray  # リスト結合
    print label_training

#    data_training  = [[x[1]] for x in data_training_tmp] # IDF値
#    label_training = [int(x[0]) for x in data_training_tmp] # わかる(1), わからない(0)

    
    # 試験データ
#data_test = 3.521

   
# 学習
    estimator = LinearSVC(C=1.0)  # モデルを定義
    estimator.fit(data_training, label_training)  # fit関数を使って教師データからパラメータを推定
    
# 予測
    label_prediction = estimator.predict([[idfValue]])
    if label_prediction == [1]:
        return 1  # わかる
    else:
        return 0  # わからない


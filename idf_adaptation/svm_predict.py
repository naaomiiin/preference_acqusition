# -*- coding: utf-8 -*-

from sklearn.svm import LinearSVC
import numpy as np


# 学習データ
data_training_tmp = np.loadtxt('data_training.txt', delimiter=' ')
data_training = [[x[1]] for x in data_training_tmp] # IDF値
label_training = [int(x[0]) for x in data_training_tmp] # わかる(1), わからない(0)

# 試験データ
#data_test = np.loadtxt('CodeIQ_mycoins.txt', delimiter=' ')
data_test = 4.442

# 学習
estimator = LinearSVC(C=1.0)  # モデルを定義
estimator.fit(data_training, label_training)  # fit関数を使って教師データからパラメータを推定

# 予測
label_prediction = estimator.predict(data_test)
if label_prediction == [1]:
    print data_test,"はわかる"
else:
    print data_test,"はわからない"

#print(label_prediction)

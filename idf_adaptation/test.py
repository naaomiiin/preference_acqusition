# coding=utf8

import numpy as np

x=10
known   = np.array([5,6,7,8,9])
unknown = np.array([4,5,6,7,8])


"""
わかる場合
"""
def known_value(known):
    v = [np.var(known), np.mean(known)]
    y = 0
    try:
        y = (1./np.sqrt(2*np.pi*v[0])) * np.exp(-(x - v[1])**2/2/v[0])   # 確率計算
    except:
        y = "error"
    return y


"""
わからない場合
"""
def unknown_value(unknown):
    v = [np.var(unknown), np.mean(unknown)]
    y = 0
    try:
        y = (1./np.sqrt(2*np.pi*v[0])) * np.exp(-(x - v[1])**2/2/v[0])   # 確率計算
    except:
        y = "error"
    return y


"""
比較して大きい方を表示
"""
def compare_value():
    if known_value(known) > unknown_value(unknown):
        result = "[[ わかる確率のほうが高い ]]"
    elif known_value(known) < unknown_value(unknown):
        result = "[[ わからない確率のほうが高い ]]"
    else:
        result = "error"
    return result


"""                                                                                                                                                                                                               
結果表示                                                                                                                                                                                                          
"""
print "\nわかる確率     => ", known_value(known), "\nわからない確率 => ", unknown_value(unknown), "\n"
print compare_value(), "\n"
    




"""
sigmas = [0.2, 1.0, 5.0, 0.5]
myus = [0, 0, 0, -2]

x = np.arange(-5., 5., 0.001)
for v in zip(sigmas,myus):
    y = (1./np.sqrt(2*np.pi*v[0])) * np.exp(-(x - v[1])**2/2/v[0])
    # plt.plot(x, y)
    #plt.show()
    print y
"""

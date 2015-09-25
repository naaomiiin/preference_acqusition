<?php


if(isset($_POST['register'])) {
  $name = $_POST['subject_name'];
  $age = $_POST['subject_age'];
  $sex = $_POST['subject_sex'];


//$data = 'Y/m/d H:i:s';

$fp = fopen("information.txt", "a");
fwrite($fp, $name . "," . $age . "," . $sex . "\n");
fclose($fp);

}


?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>アンケート</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/experiment1.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link rel="stylesheet" href="chartist/chartist.min.css">
    <script src="chartist/chartist.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head>
  <body>
    <div id="header" background="dot3.png">
      <h1>対話システム１についてのアンケート</h1><br>
<br>
</div>
    <div class="colmask rightmenu">
      <div class="container">
        <div class="row" style="height:500px;">
          <div class="col-sm-12"> <!-- カラム 1 ここから -->
  <img src="./img/lace2.png" id="left_lace">
  <img src="./img/lace2.png" id="right_lace">
<p>
   <h3>アンケートに関する説明</h3><br>
   <p id="agreement"> ここでは, 現在行った対話システムとの対話について, 以下の質問に回答して頂きます. <br> 
    質問は全部で5問あり, 「1:まったくあてはまらない」から「7:非常にあてはまる」までのいずれかを選択するか,<br>
    テキストボックスに文章を記述して回答してください. <br>
    全て回答したらページ下部の回答ボタンを押してトップページに戻ってください. <br> </p>
  <br>
  <p>
   <form id="subject_personality" action="index.html" method="POST">
          <table class="table table-striped container" style="width:1200px;">
        
          <tr class="row">
            <th class="col-sm-5">質問</th>
            <th class="col-sm-1">1: まったくあてはまらない</th>
            <th class="col-sm-1">2: ほとんどあてはまらない</th>
            <th class="col-sm-1">3: あまりあてはまらない</th>
            <th class="col-sm-1">4: どちらとも言えない</th>
            <th class="col-sm-1">5: ややあてはまる</th>
            <th class="col-sm-1">6: かなりあてはまる</th>
            <th class="col-sm-1">7: 非常にあてはまる</th>
          </tr>
        

          <tr class="row">
            <td class="col-xs-5 col-sm-5 col-md-5 col-lg-5">1.システムは自分のことをよくわかっている</td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_dom_03_1"><input id="subject_dom_03_1" type="radio" name="subject_dom_03" value="1" required>1</label></td> 
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_dom_03_2"><input id="subject_dom_03_2" type="radio" name="subject_dom_03" value="2">2</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_dom_03_3"><input id="subject_dom_03_3" type="radio" name="subject_dom_03" value="3">3</label></td> 
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_dom_03_4"><input id="subject_dom_03_4" type="radio" name="subject_dom_03" value="4">4</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_dom_03_5"><input id="subject_dom_03_5" type="radio" name="subject_dom_03" value="5">5</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_dom_03_6"><input id="subject_dom_03_6" type="radio" name="subject_dom_03" value="6">6</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_dom_03_7"><input id="subject_dom_03_7" type="radio" name="subject_dom_03" value="7">7</label></td>
          </tr>
          <tr class="row">
            <td class="col-md-5" id="adjustment">2.(1の設問に対して)なぜそう感じたのか</td> 
          　<td class="col-md-7"><input type="text" id="adjustment" name="subject_name" size="20" required><td>
          </tr>
          <tr class="row">
            <td class="col-xs-5 col-sm-5 col-md-5 col-lg-5">3.今後もこのシステムと対話をしたい</td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_1"><input id="subject_cha_10_1" type="radio" name="subject_cha_10" value="1" required>1</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_2"><input id="subject_cha_10_2" type="radio" name="subject_cha_10" value="2">2</label></td> 
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_3"><input id="subject_cha_10_3" type="radio" name="subject_cha_10" value="3">3</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_4"><input id="subject_cha_10_4" type="radio" name="subject_cha_10" value="4">4</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_5"><input id="subject_cha_10_5" type="radio" name="subject_cha_10" value="5">5</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_6"><input id="subject_cha_10_6" type="radio" name="subject_cha_10" value="6">6</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_7"><input id="subject_cha_10_7" type="radio" name="subject_cha_10" value="7">7</label></td>
          </tr>
          <tr class="row">
            <td class="col-xs-5 col-sm-5 col-md-5 col-lg-5">4.システムとの対話をもっと長く続けたい</td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_1"><input id="subject_cha_10_1" type="radio" name="subject_cha_10" value="1" required>1</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_2"><input id="subject_cha_10_2" type="radio" name="subject_cha_10" value="2">2</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_3"><input id="subject_cha_10_3" type="radio" name="subject_cha_10" value="3">3</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_4"><input id="subject_cha_10_4" type="radio" name="subject_cha_10" value="4">4</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_5"><input id="subject_cha_10_5" type="radio" name="subject_cha_10" value="5">5</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_6"><input id="subject_cha_10_6" type="radio" name="subject_cha_10" value="6">6</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="subject_cha_10_7"><input id="subject_cha_10_7" type="radio" name="subject_cha_10" value="7">7</label></td>
          </tr>
         </table>
       <div> <td class="col-sm-3"><button class="btn btn-primary" type="submit" id="adjustment" name="register" onclick="location.href='リンク先url' value="done">送信</button></div> 
    </form>                                                                                                                                                                                                                                                  
 </div>
</p>
 </div> <!-- カラム 1 ここまで -->
</div>
</div>
 <div id="buttom" style="height:100px;">
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

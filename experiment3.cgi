#!/usr/bin/perl                                                                                           
use lib '/usr/local/lib/perl/cgi-lib';
use CGI;
#------------------前準備------------------ 
$query = new CGI;
$question_01 = $query->param('01_question');
$question_02 = $query->param('02_question');
$question_03 = $query->param('03_question');
$question_04 = $query->param('04_question');
$question_05 = $query->param('05_question');
$question_06 = $query->param('06_question');
$name = $query->param('subject_name');
$age = $query->param('subject_age');
$sex =$query->param('subject_sex');

$information = $ENV{'REMOTE_ADDR'};
#------------------HTMLの表示------------------  
print "Content-type:text/html\n\n";
print << "EOF";
<html>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>対話システム３終了</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/experiment3_finish.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link rel="stylesheet" href="chartist/chartist.min.css">
    <script src="chartist/chartist.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head>
  <body>
    <div id="header" background="dot3.png">
      <h1>お疲れさまでした</h1><br>
      <br>
    </div>
    <div class="colmask rightmenu">
      <div class="container">
        <div class="row" style="height:500px;">
          <div class="col-sm-12"> <!-- カラム 1 ここから -->
            <img src="./img/lace2.png" id="left_lace">
            <img src="./img/lace2.png" id="right_lace">
            <br>
            <h3>これで対話システム３についての評価実験はおしまいです。<br>
                以下のボタンをクリックして, 指定された次の対話システムの実験を行ってください.<br>
                これが最後の実験だった方は, お手数ですが <font color="#800000"><a href="mailto:naoming.s2@gmail.com">伊藤</a></font> まで実験終了の旨をお伝えください.</h3><br><br><br>
            <h2><a href="experiment.html">評価実験一覧ページへ戻る</a></h2><br>
          </div>
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
EOF
#------------------結果をファイルに保存する------------------ 
$filename="dec_experiment.csv";
open(OUT, ">>", $filename);
print OUT $name,",",$age,",",$sex,",system3,",$question_01,",",$question_02,",",$question_03,",",$question_04,",",$question_05,",",$question_06,"\n";
close(OUT);

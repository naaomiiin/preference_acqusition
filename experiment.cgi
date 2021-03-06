#!/usr/bin/perl                                                                                           
use lib '/usr/local/lib/perl/cgi-lib';
use CGI;
#------------------前準備------------------ 
$query = new CGI;
$name = $query->param('subject_name');
$age = $query->param('subject_age');
$sex = $query->param('subject_sex');
$information = $ENV{'REMOTE_ADDR'};
#------------------HTMLの表示------------------  
print "Content-type:text/html\n\n";
print << "EOF";
<html>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>実験説明</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/experiment.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link rel="stylesheet" href="chartist/chartist.min.css">
    <script src="chartist/chartist.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    </head>
    <body>
    <div id="header" background="dot3.png">
    <h1>対話システム評価実験一覧ページ</h1><br>
    <br>
    </div>
    <div class="colmask rightmenu">
    <div class="container">
    <div class="row" style="height:600px;">
    <div class="col-sm-12"> <!-- カラム 1 ここから -->
    <span>
    <img src="./img/lace.png" id="left_lace">
    <img src="./img/lace.png" id="right_lace">
    </span>
    <div id="h2_top">
    <h2><a href="proposed_method.html">対話システム１</a></h2><br>
    <h2><a href="ntt_proposed_method.html">対話システム２</a></h2><br>
    <h2><a href="compare_method.html">対話システム３</a></h2><br>
    </div>
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
$filename="personality.csv";
open(OUT, ">>", $filename);
print OUT $information,"\n",$name,",",$age,",",$sex,"\n\n";
close(OUT);

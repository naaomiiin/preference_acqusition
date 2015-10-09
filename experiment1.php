<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>対話システム１アンケート</title>
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
   <p id="agreement"> ここではあなた自身のことと, 対話システム１との対話について, 以下の質問に回答して頂きます. <br> 
    質問は全部で6問あり, 「1:まったくあてはまらない」から「7:非常にあてはまる」までのいずれかを選択するか,<br>
    テキストボックスに文章を記述して回答してください. <br>
    全て回答したらページ下部の回答ボタンを押してトップページに戻ってください. <br> </p>
  <br>
  <p>
   <form id="subject_personality" action="experiment1.cgi" method="POST">
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
            <td class="col-xs-5 col-sm-5 col-md-5 col-lg-5">1. あなたは対話で用いた趣味について豊富な知識を持っている</td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="01_1"><input id="01_1" type="radio" name="01_question" value="1" required>1</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="01_2"><input id="01_2" type="radio" name="01_question" value="2">2</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="01_3"><input id="01_3" type="radio" name="01_question" value="3">3</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="01_4"><input id="01_4" type="radio" name="01_question" value="4">4</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="01_5"><input id="01_5" type="radio" name="01_question" value="5">5</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="01_6"><input id="01_6" type="radio" name="01_question" value="6">6</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="01_7"><input id="01_7" type="radio" name="01_question" value="7">7</label></td>
          </tr>
          <tr class="row">
            <td class="col-xs-5 col-sm-5 col-md-5 col-lg-5">2. システムは対話で用いた趣味について豊富な知識を持っている</td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="02_1"><input id="02_1" type="radio" name="02_question" value="1" required>1</label></td> 
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="02_2"><input id="02_2" type="radio" name="02_question" value="2">2</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="02_3"><input id="02_3" type="radio" name="02_question" value="3">3</label></td> 
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="02_4"><input id="02_4" type="radio" name="02_question" value="4">4</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="02_5"><input id="02_5" type="radio" name="02_question" value="5">5</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="02_6"><input id="02_6" type="radio" name="02_question" value="6">6</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="02_7"><input id="02_7" type="radio" name="02_question" value="7">7</label></td>
          </tr>
          <tr class="row">
            <td class="col-xs-5 col-sm-5 col-md-5 col-lg-5">3. 今後もこのシステムと対話をしたい</td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="03_1"><input id="03_1" type="radio" name="03_question" value="1" required>1</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="03_2"><input id="03_2" type="radio" name="03_question" value="2">2</label></td> 
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="03_3"><input id="03_3" type="radio" name="03_question" value="3">3</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="03_4"><input id="03_4" type="radio" name="03_question" value="4">4</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="03_5"><input id="03_5" type="radio" name="03_question" value="5">5</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="03_6"><input id="03_6" type="radio" name="03_question" value="6">6</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="03_7"><input id="03_7" type="radio" name="03_question" value="7">7</label></td>
          </tr>
          <tr class="row">
            <td class="col-xs-5 col-sm-5 col-md-5 col-lg-5">4. システムとの対話をもっと長く続けたい</td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="04_1"><input id="04_1" type="radio" name="04_question" value="1" required>1</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="04_2"><input id="04_2" type="radio" name="04_question" value="2">2</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="04_3"><input id="04_3" type="radio" name="04_question" value="3">3</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="04_4"><input id="04_4" type="radio" name="04_question" value="4">4</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="04_5"><input id="04_5" type="radio" name="04_question" value="5">5</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="04_6"><input id="04_6" type="radio" name="04_question" value="6">6</label></td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><label for="04_7"><input id="04_7" type="radio" name="04_question" value="7">7</label></td>
          </tr>
         </table>
	 <br><br>
	 <table class="table table-striped container" style="width:1200px;">
	 <tr class="row">
            <td id="question_5" class="col-xs-5 col-sm-5 col-md-5 col-lg-5">5. 設問2に対してなぜそう感じたのか</td>
	    <td><textarea  id="text_5" class="col-xs-7 col-sm-7 col-md-7 col-lg-7" name="05_question"></textarea></td>
    	 </tr>
	 <tr class="row">
            <td id="question_6" class="col-xs-5 col-sm-5 col-md-5 col-lg-5">6. 設問3,4に対してなぜそう感じたのか</td>
            <td><textarea id="text_6" class="col-xs-7 col-sm-7 col-md-7 col-lg-7" name="06_question"></textarea></td>
         </tr>
         </table>
	 <br><br>
         <table class="table table-striped container">                                                                                                                                                                                                 
           <tr class="row">                                                                                                                                                                                                                            
             <td class="col-md-4" id="adjustment">被験者番号（半角数字)  　<input type="text" id="adjustment" name="subject_name" size="20" required></td>                                                                                                  
             <td class="col-md-4" id="adjustment">年齢  　<input type="number" id="adjustment" name="subject_age" size="20" min="0" required></td>                                                                                                     
             <td class="col-md-4" id="adjustment">性別  　<select name="subject_sex" id="adjustment" required>                                                                                                                                         
                 <option value="" disabled></option>                                                                                                                                                                                                   
                 <option value="男性" id="adjustment">男性</option>                                                                                                                                                                                    
                 <option value="女性" id="adjustment">女性</option>                                                                                                                                                                                    
             </select></td>                                                                                                                                                                                                                            
	   </tr>                                                                                                                                                                                                                                       
	 </table>                                                                                                                                                                                                                                      
	 
	 
	 <div> <td class="col-sm-3"><button class="btn btn-primary" type="submit" id="adjustment" name="register" value="done">送信</button></div> 
       <br>
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

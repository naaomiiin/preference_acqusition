<html>
<head><title>PHP TEST</title></head>
<body>

<?php

// Common
define('WIKIPEDIA_API_URL', 'http://ja.wikipedia.org/wiki/%E7%89%B9%E5%88%A5:%E3%83%87%E3%83%BC%E3%82%BF%E6%9B%B8%E3%81%8D%E5%87%BA%E3%81%97');
define('MECAB_STRING_CUT_LENGTH','8');
define('LOOP_MAX_COUNT','3');

// いらない文字列を排除する．純粋な配列に成形
function clearString($str){
  $tmpArray = array();

  for( $i=0; $i < count($str); $i++){
    $replace = substr( $str[$i] , MECAB_STRING_CUT_LENGTH , strlen($str[$i]) - MECAB_STRING_CUT_LENGTH );
    // 日本語の判定
    if (preg_match("/^[ぁ-んァ-ヶー一-龠]+$/u", $replace)) {
      // 日本語の，それ，こと以外
      if(
          strcmp($replace, "それ") != 0 &&
          strcmp($replace, "こと") != 0
        )
      {
            array_push($tmpArray, $replace);
      }
    }
  }
  return $tmpArray;
}


// IDFの取得
function get_IDF_return($ret_array, $n){
  $con = mysql_connect('localhost', 'klab', '0nsayken9');
  if (!$con) {
    exit('データベースに接続できませんでした。');
  }

  $result = mysql_select_db('naomi', $con);
  if (!$result) {
    exit('データベースを選択できませんでした。');
  }

  $result = mysql_query('SET NAMES utf8', $con);
  if (!$result) {
    exit('文字コードを指定できませんでした。');
  }


  $result = mysql_query('SELECT 単語,出現ページ数,IDF値 from idf');

  $mysql_data_array = array();

  foreach($ret_array as $value){
    $word = rtrim($value,"\n");
    $sql = "SELECT *  FROM idf WHERE 単語 = '$word';";
    $result = mysql_query($sql);
  
  while($line =  mysql_fetch_assoc($result)){
      array_push($mysql_data_array, $line);
    }
  }

  foreach($mysql_data_array as $key => $value){
      $key_id[$key] = $value['IDF値'];
  }

 if(is_array($value)){

    array_multisort($key_id, SORT_DESC, $mysql_data_array);
    //print $mysql_data_array[0]["単語"];
    //print $mysql_data_array[0]["IDF値"]."\n";

    $r_mysql_data_array = array_reverse($mysql_data_array);
    //print $r_mysql_data_array[0]["単語"];
    //print $r_mysql_data_array[0]["IDF値"]."\n";

/*
  for($i = 0; $i < count($mysql_data_array); $i++){
        print $mysql_data_array[$i]["単語"] . "\t";
        print $mysql_data_array[$i]["IDF値"] . "\n";
  }
 */

    $properNoun = exec('echo "'.
                       $mysql_data_array[0].
                       '"| mecab', $propData);

    if(is_array($propData)){
      for($i = 0; $i < count($propData); $i++){
        $properNoun .= $propData[$i];
      }
    }else{
      $properNoun = $propData;
    }

    $comparePropernoun = "固有名詞";
    $compareNoun = "名詞";

    $index = $n - 1;

    if(strstr($properNoun, $comparePropernoun)){
      // 固有名詞かどうか
      //return $mysql_data_array[$index]["単語"] . "についてどう思いますか？<br>" . $mysql_data_array[$index]["単語"] . "<br>" . $mysql_data_array[$index]["IDF値"] . "<br>";
     
      $reply = $mysql_data_array[$index]["単語"] . "についてどう思いますか？";
      $noun = $mysql_data_array[$index]["単語"];
      $idf = floatval($mysql_data_array[$index]["IDF値"]);    

      $json_array= array(
        'reply'=> $reply,
        'noun'=> $noun,
        'idf'=> $idf,
        'condition' => 'ok'
      );
      return json_encode($json_array);

    }elseif(strstr($properNoun, $compareNoun)){
      // 一般名詞かどうか
      //return "好きな" . $mysql_data_array[$index]["単語"] . "は何ですか？<br>" . $mysql_data_array[$index]["単語"] . "<br>" . $mysql_data_array[$index]["IDF値"] . "<br>";

      $reply = "好きな" . $mysql_data_array[$index]["単語"] . "は何ですか？";
      $noun = $mysql_data_array[$index]["単語"];
      $idf = floatval($mysql_data_array[$index]["IDF値"]);

      $json_array= array(
        'reply'=> $reply,
        'noun'=> $noun,
        'idf'=> $idf,
        'condition' => 'ok'
      );
      return json_encode($json_array);
    
    }else{
      //return "そうなんですね。\n       他の趣味はありますか？\n";
      $json_array= array(
           'condition' => 'other question'
      );
      return json_encode($json_array);
    }
  }
}




// 関数　
function nouns_from_wiki($str){
  // Create stream (constructer)
  $stream_context = stream_context_create(array(
      'http' => array(
          'method' => 'GET',
          'header' => 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
      ),
  ));

  // Get html data using http, URL encode
  $wiki_data = file_get_contents(WIKIPEDIA_API_URL. '/'. urldecode( $str ) , false, $stream_context);

  // encode raw data
  $wiki_data_encode = mb_detect_encoding( $wiki_data );

  // text tag
  if (preg_match('/<text(.*?)<\/text>/s', mb_convert_encoding($wiki_data, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
    $text = $result[0];
    //print $text . "\n";
  }else{
    // page not found
    return 10001;
  }

  $noun = exec('echo "'.
               $text.
             '"| mecab | grep "名詞" | cut -f 1| sort | uniq -c | sort -n', $ma);
  //var_dump($ma);

  // Only Japanese
  $tmp_array = clearString($ma);
  return $tmp_array;
}




$qStateTemp = "Start";
$qDataTemp = "";
$loopCount = 0;
$n = 1;
$prev_nouns;
$input_data = $_GET['keyword'];

//print "--------- Start System ---------\n\n";
//print " Sys : あなたの趣味はなんですか？\n";
//echo '<p>  Sys : あなたの趣味はなんですか？</p>';
//echo "<p>  You : ${input_data}</p>";

// main point
while (1){
  // Initilize
  $ma = null;
  $string_Array = array();
  $oneSentence = -1;
  $bindString = "";
  $replace = "";
  if($loopCount >= LOOP_MAX_COUNT){
     // print $loopCount;
      $qStateTemp = "Exit";
  }


//  print " You : ";
//  fscanf(STDIN, "%s", $in);

  // 入力状態を保管
  switch ($input_data) {
    case 'exit':
        $qStateTemp = "Exit";
      break;

      default:

    $noun = exec('echo '.
                 $input_data.
                 '| mecab | grep "名詞" | cut -f 1| uniq -c', $ma);

    if (is_array($ma)) {
        // 名詞を抜き出す
        //var_dump($ma);
        for( $i=0; $i < count($ma); $i++){
          
          $replace = substr( $ma[$i] , MECAB_STRING_CUT_LENGTH , strlen($ma[$i])-MECAB_STRING_CUT_LENGTH );

          if(
              strcmp($replace, "私") != 0 &&
              strcmp($replace, "する") != 0 &&
              strcmp($replace, "こと") != 0
            ){
              array_push($string_Array, $replace);
            }
        }
    } else {
      // 名詞確定
      $oneSentence = substr( $input_data , MECAB_STRING_CUT_LENGTH , strlen($input_data) - MECAB_STRING_CUT_LENGTH );
    }

    
    if ($oneSentence == -1){
      $bindStrings = "";
      for( $i=0; $i < count($string_Array); $i++){
         //ユーザが入力した単語を全て表示
         // print $string_Array[$i]."\n";
         $bindStrings .= $string_Array[$i];
      }


      //ユーザが入力した単語に連続する名詞があれば繋げて表示 
      $resultCode = nouns_from_wiki($bindStrings);
    }else{
      $resultCode = nouns_from_wiki($oneSentence);
    }

    /*
    if($input_data == "わかりません"){
        //$n++;
        //print get_IDF_return($prev_nouns, $n);
            $json_array= array(
                'condition' => 'other question'
            );
        print json_encode($json_array);
    */     

    if(empty($string_Array)){    //名詞が抽出できない場合
        $n=1;
        $json_array= array(
            'condition' => 'error'
        );
        print json_encode($json_array);
    }elseif(nouns_from_wiki($bindStrings) == 10001){    // wikipediaのページが見つからない場合
        $n = 1;
        $json_array= array(
            'condition' => 'other question'
        );
        print json_encode($json_array);
    }else{     // 次にシステムのとる行動を計算
        $n = 1;
        $nouns = nouns_from_wiki($bindStrings);
	//$prev_nouns = $nouns;
        print get_IDF_return($nouns, $n);
        $loopCount ++;
    }
      //break;
  }
 break;
}

?>
</body>
</html>

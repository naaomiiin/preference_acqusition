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
          strcmp($replace, "こと") != 0 &&
          strcmp($replace, "もの") != 0
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

//  $ret_array = $arrayStr;
  $mysql_data_array = array();

  foreach((array)$ret_array as $value){
    $word = rtrim($value,"\n");
    $sql = "SELECT *  FROM idf WHERE 単語 = '$word';";
    $result = mysql_query($sql);
  
  while($line =  mysql_fetch_assoc($result)){
      array_push($mysql_data_array, $line);
    }
  }

  foreach($mysql_data_array as $key => $value){
      $key_id[$key] = $value["IDF値"];
  }

  if(is_array($value)){
  
    array_multisort($key_id, SORT_DESC, $mysql_data_array);
    //print $mysql_data_array[0]["単語"];
    //print $mysql_data_array[0]["IDF値"]."\n";

    $r_mysql_data_array = array_reverse($mysql_data_array);
    //print $r_mysql_data_array[0]["単語"];
    //print $r_mysql_data_array[0]["IDF値"]."\n";
 
  
  for($i = 0; $i < count($mysql_data_array); $i++){
       // print $mysql_data_array[$i]["単語"] . "\t";
       // print $mysql_data_array[$i]["IDF値"] . "\n";
  }
 

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

 if(isset($mysql_data_array[$index]["単語"])){

    if(strstr($properNoun, $comparePropernoun)){
      // 固有名詞かどうか
      return  "Sys : " . $mysql_data_array[$index]["単語"] . "についてどう思いますか？\n";
    }elseif(strstr($properNoun, $compareNoun)){
      // 一般名詞かどうか
      return " Sys : 好きな" . $mysql_data_array[$index]["単語"] . "は何ですか？\n";
    }else{    
      return " Sys : そうなんですね。\n       他の趣味はありますか？\n";
   } 
}else{
return " Sys : そうなんですね。\n       他の趣味はありますか？\n";
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
    $noun = exec('echo "'.
               $text.
             '"| mecab | grep "名詞" | cut -f 1| sort | uniq -c | sort -n', $ma);

  // Only Japanese
  $tmp_array = clearString($ma);
  return $tmp_array;

 }else{
    // page not found
    $noun = exec('echo "'.
           $str.
             '"| mecab | grep "名詞" | cut -f 1 | sort | uniq -c | sort -n', $ma);
    
  $tmp_array = clearString($ma);
  return $tmp_array;

  }
}


?>


<?php
$qStateTemp = "Start";
$qDataTemp = "";
$loopCount = 0;
$n = 1;
$prev_nouns;

print "--------- Start System ---------\n\n";
print " Sys : あなたの趣味はなんですか？\n";

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


  print " You : ";
  fscanf(STDIN, "%s", $in);

  // 入力状態を保管
  switch ($in) {
    case 'exit':
        $qStateTemp = "Exit";
      break;

      default:

    $noun = exec('echo '.
                 $in.
                 '| mecab | grep "名詞" | cut -f 1| uniq -c', $ma);

    if (is_array($ma)) {
        // 名詞を抜き出す
        //var_dump($ma);
        for( $i=0; $i < count($ma); $i++){
          
          $replace = substr( $ma[$i] , MECAB_STRING_CUT_LENGTH , strlen($ma[$i])-MECAB_STRING_CUT_LENGTH );

          if(
              strcmp($replace, "私") != 0 &&
              strcmp($replace, "する") != 0 &&
              strcmp($replace, "こと") != 0 &&
              strcmp($replace, "もの") != 0 && 
              strcmp($replace, "やつ") != 0 &&
              strcmp($replace, "ほう") != 0 &&
              strcmp($replace, "それ") != 0
           ){
              array_push($string_Array, $replace);
            }
        }
    } else {
      // 名詞確定
      $oneSentence = substr( $in , MECAB_STRING_CUT_LENGTH , strlen($in) - MECAB_STRING_CUT_LENGTH );
    }
    
    if ($oneSentence == -1){
      $bindStrings = "";
      for( $i=0; $i < count($string_Array); $i++){
         //ユーザが入力した単語を全て表示
         //print $string_Array[$i]."\n";
         $bindStrings .= $string_Array[$i];
      }

      //ユーザが入力した単語に連続する名詞があれば繋げて表示 
      $resultCode = nouns_from_wiki($bindStrings);  
  }else{
      $resultCode = nouns_from_wiki($string_Array[0]);
   }


    if($in == "わかりません"){
//        $n++;
//        print get_IDF_return($prev_nouns, $n);	  

	if (isset($prev_nouns) ) {
	   $n++;
	   print get_IDF_return($prev_nouns, $n);
	}else{
	   $n++;
	   print " Sys : そうなんですね。\n       他の趣味はありますか？\n";	   
	}      

    }elseif(empty($string_Array)){
        $n=1;
        //2番目をとってきて出力
        // Systemを遷移する
       	//$qStateTemp = "Error";
	 //print ("$string_Arrayは0か空です。\n");
/*
    }elseif($text = 0){        
    	$n = 1;
	//wikipediaページ見つからない
print "遷移OK".$resultCode[0];
	$nouns = nouns_from_wiki($resultCode[0]);
	$prev_nouns = $nouns;
	print get_IDF_return($nouns, $n);
	$loopCount ++;
*/
    }else{
        $n = 1;
        // 形態素解析し，次にシステムのとる行動を計算
        $nouns = nouns_from_wiki($bindStrings);
	$prev_nouns = $nouns;
        print get_IDF_return($nouns, $n);
        $loopCount ++;
    }
   break;
  }
}

?>






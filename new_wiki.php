<?php
// Error Code
// 10001 = not found

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

// IDFを計算し，次の遷移
function keyword_n($arrayStr, $n){
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

  $ret_array = $arrayStr;
  $idf_array = array();

  foreach($ret_array as $value){
    $word = rtrim($value,"\n");
    $sql = "SELECT *  FROM idf WHERE 単語 = '$word';";

    $result = mysql_query($sql);
   // print $sql . "\n";
while($line =  mysql_fetch_assoc($result)){
      array_push($idf_array, $line);
    }
  }

  foreach($idf_array as $key => $value){
      $key_id[$key] = $value['IDF値'];
  }

  array_multisort($key_id, SORT_DESC, $idf_array);
  //print $idf_array[0]["単語"];
  //print $idf_array[0]["IDF値"]."\n";

  $r_idf_array = array_reverse($idf_array);
  //print $r_idf_array[0]["単語"];
  //print $r_idf_array[0]["IDF値"]."\n";
 
  for($i = 0; $i < count($idf_array); $i++){
  //      print $idf_array[$i]["単語"] . "\t";
  //      print $idf_array[$i]["IDF値"] . "\n";
  }

  $file_write = `echo $idf_array[0] > sample.txt`;
  
  $properNoun = exec('echo "'.
             $idf_array[0].
             '"| mecab', $propData);

  if(is_array($propData)){  
    for($i = 0; $i < count($propData); $i++){
      $properNoun .= $propData[$i]; 
    }
  }else{
    $properNoun = $propData;
  }

  $comparePropernoun = '固有名詞';
  $compareNoun = '名詞';
  
  $index = $n - 1;

  if(strstr($properNoun, $comparePropernoun)){
    // 固有名詞かどうか
    return  "Sys : " . $idf_array[$index]["単語"] . "についてどう思いますか？\n";
  }elseif(strstr($properNoun, $compareNoun)){
    // 一般名詞かどうか
    return " Sys : 好きな" . $idf_array[$index]["単語"] . "は何ですか？\n";
  }else{
    return  " Sys : そうなんですね。\n       他の趣味はありますか？\n";
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
    var_dump ( $result );
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

// Conduct System
//  questionState($qStateTemp, $qDataTemp);
//  print "FIXME";
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
              strcmp($replace, "こと") != 0
            )
          {
              array_push($string_Array, $replace);
          }
        }
    } else {
      // 名詞確定
      $oneSentence = substr( $in , MECAB_STRING_CUT_LENGTH , strlen($in) - MECAB_STRING_CUT_LENGTH );
    }

    //print $string_Array[0];
    //var_dump($string_Array);
    
    if ($oneSentence == -1)
    {
      $bindStrings = "";
      for( $i=0; $i < count($string_Array); $i++){
       //ユーザが入力した単語を全て表示
       // print $string_Array[$i]."\n";
        $bindStrings .= $string_Array[$i];
      }
     //ユーザが入力した単語に連続する名詞があれば繋げて表示 
      //print $bindStrings;

      $resultCode = nouns_from_wiki($bindStrings);
    }else{
      $resultCode = nouns_from_wiki($oneSentence);
    }
    
      if($in == "わかりません"){

        $n++;
        print keyword_n($prev_nouns, $n);
      
      }elseif(empty($string_Array)){
        $n=1;
        //2番目をとってきて出力
        // Systemを遷移する
       	//$qStateTemp = "Error";
	 //print ("$string_Arrayは0か空です。\n");
      }elseif($resultCode == 10001){
        $n = 1;
        // wikipediaのページが見つからない
        //print("変わった趣味をお持ちのようですね．\n");
        $nouns = nouns_from_wiki($string_Array[0]);
       	print keyword_n($nouns, 1);
      }else{
        $n = 1;
        // 形態素解析し，次にシステムのとる行動を計算
        $nouns = nouns_from_wiki($string_Array[0]);
	$prev_nouns = $nouns;
        print keyword_n($nouns, $n);
        $loopCount ++;
      }

      break;
  }

}


<?php

/*==================================

Wikipedia からデータを取得するプログラム

==================================*/


/*== Wikipedia API の URL =======================*/// 
define('WIKIPEDIA_API_URL', 'http://ja.wikipedia.org/wiki/%E7%89%B9%E5%88%A5:%E3%83%87%E3%83%BC%E3%82%BF%E6%9B%B8%E3%81%8D%E5%87%BA%E3%81%97');


/*== 取得するタイトル =======================*/
print "\n=== はじまり ===\n";
print "システム : ";
print "あなたの趣味は？\n";

$fp = fopen("get_title.txt", "w");
print " あなた  : ";
fwrite($fp, rtrim(fgets(STDIN), "\n"));
fclose($fp);

$file = `mecab get_title.txt | grep "名詞"| cut -f 1 | uniq -c  > get_title_2.txt`;
$output = `cat get_title_2.txt | awk '{print substr($0, 9)}' > get_title_3.txt`;     
$remove = `cat get_title_3.txt | sed '/もの/d'| sed '/こと/d'|sed '/私/d'| sed '/'\''/d' > get_title_4.txt`;

$list = file('get_title_4.txt');
$list = file('get_title_4.txt', FILE_IGNORE_NEW_LINES);


/*== ストリームコンテキストの生成 =======================*/
$stream_context = stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
    ),
));


/*== データの取得 =======================*/

/*
$wiki_data = file_get_contents(WIKIPEDIA_API_URL. '/'. urldecode( $list[0].$list[1] ) , false, $stream_context);
if ($wiki_data == false) {
    $wiki_data = file_get_contents(WIKIPEDIA_API_URL. '/'. urldecode( $list[0] ) , false, $stream_context);
}
*/

if (isset( $list[1] )){
   $wiki_data = file_get_contents(WIKIPEDIA_API_URL. '/'. urldecode( $list[0].$list[1] ) , false, $stream_context);
}else{
   $wiki_data = file_get_contents(WIKIPEDIA_API_URL. '/'. urldecode( $list[0] ) , false, $stream_context);
}
//echo $wiki_data;

/*== 結果出力 =======================*/
$wiki_data_encode = mb_detect_encoding( $wiki_data );


/*== textタグ内容抽出 =======================*/
if (preg_match('/<text(.*?)<\/text>/s', mb_convert_encoding($wiki_data, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
    $text = $result[1];

/*== キーワードWikipediaページ単語一覧抽出 =======================*/
$fp = fopen("wiki_data.txt", "w");
fwrite($fp, $text);
$file = `mecab wiki_data.txt | grep "名詞" | cut -f 1 | sort | uniq -c | sort -n > wiki_data_list.txt`;	//出現回数、単語一覧
$output = `cat wiki_data_list.txt | awk '{print substr($0, 9)}' > wiki_data_list_2.txt`;		//単語一覧のみに成形
//echo $output;
$remove = `cat wiki_data_list_2.txt | sed '/もの/d'| sed '/こと/d'| sed '/それ/d'| sed '/'\''/d'| sed '/'\-'/d'|sed '/'\"'/d'| sed '/'\;'/d'| sed '/Ä/d'| sed '/ä/d'| sed '/Ö/d'| sed '/ö/d'| sed '/Ü/d'| sed '/ü/d'| sed '/ß/d'| sed -e 's/'[a-zA-Z0-9]'//g' | sed -e 's/'[Ａ-Ｚ]'//g'|sed -e 's/'[À-ÿ]'//g' | sed -e '/^ *$/d'> wiki_data_list_3.txt`;   //対象外文字列削除

fclose($fp);
} else {
   //TITLEタグが存在しない場合
//      $text = $result[0];
      echo "そうなんですね。\n他の趣味はありますか？\n";
}


/*== MySQL接続 =======================*/

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

$file_name = "wiki_data_list_3.txt";
$ret_array = file( $file_name );

$idf_array = array();

foreach($ret_array as $value){
        $word = rtrim($value,"\n");
	$sql = "SELECT *  FROM idf WHERE 単語 = '$word';";

//	print $sql."\n";
	
	$result = mysql_query($sql);
	while($line =  mysql_fetch_assoc($result)){
	        array_push($idf_array,$line);
	}
}

//print $idf_array[0]["単語"]."\n";

foreach($idf_array as $key => $value){
    $key_id[$key] = $value['IDF値'];
}

array_multisort($key_id,SORT_DESC,$idf_array);
//print $idf_array[0]["単語"];
//print $idf_array[0]["IDF値"]."\n";

$r_idf_array = array_reverse($idf_array);
//print $r_idf_array[0]["単語"];
//print $r_idf_array[0]["IDF値"]."\n";

for($i = 0; $i < count($idf_array); $i++){
      print $idf_array[$i]["単語"] . "\t";
      print $idf_array[$i]["IDF値"] . "\n";
}


$file_write = `echo $idf_array[0] > sample.txt`;
$mecab = `mecab sample.txt`;   //キーワードを形態素解析
$fhn = 'sample.txt';
$str = '固有名詞';

print "システム : ";

if(strstr($fhn,$str)){
	print $idf_array[0]["単語"] . "についてどう思いますか？\n";
}else{
	print "好きな" . $idf_array[0]["単語"] . "は何ですか？\n";
}


/*
if (isset($idf_array[100]["単語"])){
   print $idf_array[0]["単語"] . "や" . $idf_array[100]["単語"] . "についてどう思いますか？\n";
}elseif(isset($idf_array[70]["単語"])){
   print $idf_array[0]["単語"] . "や" . $idf_array[70]["単語"] . "についてどう思いますか？\n";
}elseif(isset($idf_array[50]["単語"])){
   print $idf_array[0]["単語"] . "や" . $idf_array[50]["単語"] . "についてどう思いますか？\n";
}elseif(isset($idf_array[20]["単語"])){
   print $idf_array[0]["単語"] . "や" . $idf_array[20]["単語"] . "についてどう思いますか？\n";
}elseif(isset($idf_array[5]["単語"])){
   print $idf_array[0]["単語"] . "や" . $idf_array[5]["単語"] . "についてどう思いますか？\n";
}else{
   print $idf_array[0]["単語"] . "についてどう思いますか？\n";
}
*/


$fp = fopen("get_title.txt", "w");
print " あなた  : ";		
fwrite($fp, rtrim(fgets(STDIN), "\n"));	//ユーザー２発話目
fclose($fp);

//$user2 = 'get_title_4.txt';
//$search_title_2 = file( $user2 );

$file = `mecab get_title.txt | grep "名詞"| cut -f 1 | uniq -c  > get_title_2.txt`;
$output = `cat get_title_2.txt | awk '{print substr($0, 9)}' > get_title_3.txt`;
$remove = `cat get_title_3.txt | sed '/もの/d'| sed '/こと/d'|sed '/私/d'| sed '/'\''/d' > get_title_4.txt`;

$list = file('get_title_4.txt');
$list = file('get_title_4.txt', FILE_IGNORE_NEW_LINES);



/*== ストリームコンテキストの生成 =======================*/
$stream_context = stream_context_create(array(
    'http' => array(
    'method' => 'GET',
        'header' => 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
    ),
));

/*== データの取得 =======================*/
$wiki_data_2 = file_get_contents(WIKIPEDIA_API_URL. '/'. urldecode( $list[0].$list[1] ) , false, $stream_context);
if ($wiki_data_2 == false) {
    $wiki_data_2 = file_get_contents(WIKIPEDIA_API_URL. '/'. urldecode( $list[0] ) , false, $stream_context);
}


/*== 結果出力 =======================*/
$wiki_data_encode = mb_detect_encoding( $wiki_data_2 );


/*== textタグ内容抽出 =======================*/
if (preg_match('/<text(.*?)<\/text>/s', mb_convert_encoding($wiki_data_2, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
    $text = $result[1];
} else {
   //TITLEタグが存在しない場合
    $text = $url;
      echo "そうなんですね。\n他の趣味はありますか？\n";
}
//echo $text;


/*== キーワードWikipediaページ単語一覧抽出 =======================*/
$fp = fopen("wiki_data.txt", "w");
fwrite($fp, $text);
$file = `mecab wiki_data.txt | grep "名詞" | cut -f 1 | sort | uniq -c | sort -n > wiki_data_list.txt`; //出現回数、単語一覧
$output = `cat wiki_data_list.txt | awk '{print substr($0, 9)}' > wiki_data_list_2.txt`;                //単語一覧のみに成形
//echo $output;
$remove = `cat wiki_data_list_2.txt | sed '/もの/d'| sed '/こと/d'| sed '/それ/d'| sed '/'\''/d'| sed '/'\-'/d'|sed '/'\"'/d'| sed '/'\;'/d'| sed '/Ä/d'| sed '/ä/d'| sed '/Ö/d'| sed '/ö/d'| sed '/Ü/d'| sed '/ü/d'| sed '/ß/d'| sed -e 's/'[a-zA-Z0-9]'//g' | sed -e 's/'[Ａ-Ｚ]'//g'|sed -e 's/'[À-ÿ]'//g' | sed -e '/^ *$/d'> wiki_data_list_3.txt`;   //対象外文字列削除


/*== MySQL接続 =======================*/

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

$file_name = "wiki_data_list_3.txt";
$ret_array_s = file( $file_name );

$idf_array_s = array();

foreach($ret_array_s as $value_s){
        $word = rtrim($value_s,"\n");
        $sql = "SELECT *  FROM idf WHERE 単語 = '$word';";

//echo `cat wiki_data_list_3.txt`;
//fclose($fp);

        $result = mysql_query($sql);
        while($line =  mysql_fetch_assoc($result)){
                array_push($idf_array_s,$line);
        }
}

foreach($idf_array_s as $key => $value_s){
    $key_id_s[$key] = $value_s['IDF値'];
}

array_multisort($key_id_s,SORT_DESC,$idf_array_s);
//print $idf_array_s[0]["単語"];
//print $idf_array_s[0]["IDF値"]."\n";

$r_idf_array_s = array_reverse($idf_array_s);
//print $r_idf_array_s[0]["単語"];
//print $r_idf_array_s[0]["IDF値"]."\n";

for($i = 0; $i < count($idf_array_s); $i++){
//      print $idf_array_s[$i]["単語"] . "\t";
//      print $idf_array_s[$i]["IDF値"] . "\n";
}

print "システム : ";
print $idf_array_s[0]["単語"] . "についてどう思いますか？\n";


/*
if (isset($idf_array_s[100]["単語"])){
   print $idf_array_s[0]["単語"] . "や" . $idf_array_s[100]["単語"] . "についてどう思いますか？\n";
}elseif(isset($idf_array_s[70]["単語"])){
   print $idf_array_s[0]["単語"] . "や" . $idf_array_s[70]["単語"] . "についてどう思いますか？\n";
}elseif(isset($idf_array_s[50]["単語"])){
   print $idf_array_s[0]["単語"] . "や" . $idf_array_s[50]["単語"] . "についてどう思いますか？\n";
}elseif(isset($idf_array_s[20]["単語"])){
   print $idf_array_s[0]["単語"] . "や" . $idf_array_s[20]["単語"] . "についてどう思いますか？\n";
}elseif(isset($idf_array_s[5]["単語"])){
   print $idf_array_s[0]["単語"] . "や" . $idf_array_s[5]["単語"] . "についてどう思いますか？\n";
}else{
   print $idf_array_s[0]["単語"] . "についてどう思いますか？\n";
}
*/


print " あなた  ：";
$l = fgets(STDIN);



$con = mysql_close($con);
if (!$con) {
  exit('データベースとの接続を閉じられませんでした。');
}


print "\n=== おわり ===\n";


?>
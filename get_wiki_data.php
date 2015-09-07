<?php

/*==================================

Wikipedia からデータを取得するプログラム

==================================*/




/*== Wikipedia API の URL =======================*/// 
define('WIKIPEDIA_API_URL', 'http://ja.wikipedia.org/wiki/%E7%89%B9%E5%88%A5:%E3%83%87%E3%83%BC%E3%82%BF%E6%9B%B8%E3%81%8D%E5%87%BA%E3%81%97');


/*== 取得するタイトル =======================*/
$search_title = '書道';


/*== ストリームコンテキストの生成 =======================*/
$stream_context = stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
    ),
));


/*== データの取得 =======================*/
$wiki_data = file_get_contents(WIKIPEDIA_API_URL. '/'. urlencode($search_title) , false, $stream_context);


/*== 結果出力 =======================*/
$wiki_data_encode = mb_detect_encoding($wiki_data);
header('Content-Type: text/html; charset='. $wiki_data_encode);
//echo $wiki_data;


/*== textタグ内容抽出 =======================*/
if (preg_match('/<text(.*?)<\/text>/s', mb_convert_encoding($wiki_data, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
    $text = $result[1];
} else {
   //TITLEタグが存在しない場合
    $text = $url;
}
//echo $text;


/*== キーワードWikipediaページ単語一覧抽出 =======================*/
$fp = fopen("wiki_data.txt", "w");
fwrite($fp, $text);
$file = `mecab wiki_data.txt | grep "名詞" | cut -f 1 | sort | uniq -c | sort -n > wiki_data_list.txt`;	//出現回数、単語一覧
$output = `cat wiki_data_list.txt | awk '{print substr($0, 9)}' > wiki_data_list_2.txt`;		//単語一覧のみに成形
//echo $output;
$remove = `cat wiki_data_list_2.txt | sed '/;/d'| sed '/quot/d'| sed '/ref/d'| sed '/1/d'| sed '/2/d'| sed '/3/d'| sed '/4/d'| sed '/5/d'| sed '/6/d'| sed '/7/d'| sed '/8/d'| sed '/9/d'| sed '/0/d'| sed '/-/d'| sed '/name/d'| sed '/right/d'| sed '/thumb/d'| sed '/main/d'| sed '/class/d'| sed '/jpg/d'| sed '/div/d'| sed '/もの/d'| sed '/こと/d'| sed '/それ/d'| sed '/kojien/d'| sed '/list/d'| sed '/columns/d'| sed '/date/d' > wiki_data_list_3.txt`;   //対象外文字列削除
//echo $remove;
//echo `cat wiki_data_list_3.txt`;
fclose($fp);


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


GLOBAL $ret_array;
GLOBAL $i;
$i = 1;
$file_name = "wiki_data_list_3.txt";
$ret_array = file( $file_name );


while($i < count($ret_array)){
//echo $ret_array[$i];
$i++;
}
//echo $ret_array[927];

$result = mysql_query('SELECT * FROM idf', $con);


while ($data = mysql_fetch_array($result)){
      
       if($data[0] == "書道"){
     //if($data[0] == $ret_array[927]){
     	 echo $data[0] . "\t" . $data[1] . "\t" . $data[2] . "\n";         //$data[0]:単語, $data[1]:出現ページ数, $data[2]:IDF値
  	}else{
      	 echo "";
     	}
}

$con = mysql_close($con);
if (!$con) {
  exit('データベースとの接続を閉じられませんでした。');
}

?>
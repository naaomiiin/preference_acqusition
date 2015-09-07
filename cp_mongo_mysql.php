<?php


/////////////////////////////////////////////////  mysql

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

/*
$result = mysql_query('SELECT * FROM idf', $con);
while ($data = mysql_fetch_array($result)) {
  echo  $data['単語'] . ':' . $data['出現ページ数'] . ':' . $data['IDF値'] . "\n";
}

$con = mysql_close($con);
if (!$con) {
  exit('データベースとの接続を閉じられませんでした。');
}
*/



/////////////////////////////////////////////////  mongo

// DBへ接続
$mongo = new Mongo();

// データベースを指定
$db = $mongo->selectDB("misc");

// コレクションを指定
$col = $db->selectCollection("naomi");

// コレクションの指定したドキュメントを取得
$cursor = $col->find();
//$cursor = $col->find(array("inscribe" => "⽀援"));

/*
// 表示
foreach ($cursor as $id =>$obj) {
        $result = array_slice($obj,-9,1);
	//var_dump(implode($result));
	   //var_dump($output);
	//echo $result[1] . "\n\n";
	if (strstr(implode($result), "書道")) {
  	   echo "URLに「/shop/item」が含まれています。";
 	   } else {
 	   echo "URLに「/shop/item」が含まれていません。";
 	}
}
*/

/////////////////////////////////////////////////  共通した単語のみ表示

$result = mysql_query('SELECT * FROM idf', $con);
while ($data = mysql_fetch_array($result)) {
      foreach ($cursor as $id =>$obj) {

       	$slice = array_slice($obj,-9,1);
	$text_fam = array_slice($obj,-13,1);
	$text_fam = implode($text_fam) . "\n";
	
	if (implode($slice) === $data['単語']) {
           echo $data['単語'] . ':' . $data['出現ページ数'] . ':' . $data['IDF値'] . ':' . $text_fam . "\n";
	   $all = $data['単語'] . ':' . $data['出現ページ数'] . ':' . $data['IDF値'] . ':' . $text_fam . "\n";
	   
	   $fhn_mongo = fopen("./mongo.txt","a");
           fwrite($fhn_mongo,$all);
           fclose($fhn_mongo);	  

 
	   $data_tango = $data['単語'] . "\n";
	   $data_page = $data['出現ページ数'] . "\n";
	   $data_idf = $data['IDF値'] . "\n";

	   $fhn_tango = fopen("./data_tango.txt","a");
	   fwrite($fhn_tango,$data_tango);
	   fclose($fhn_tango);

	   $fhn_page = fopen("./data_page.txt","a");
           fwrite($fhn_page,$data_page);
           fclose($fhn_page);
	   
	   $fhn_idf = fopen("./data_idf.txt","a");
           fwrite($fhn_idf,$data_idf);
           fclose($fhn_idf);

	   $fhn_text_fam = fopen("./data_text_fam.txt","a");
           fwrite($fhn_text_fam,$text_fam);
           fclose($fhn_text_fam);



	   //echo "配列に" . $data['単語'] . "が含まれています。\n";
        } else {
           echo implode($slice) . "に" . $data['単語'] . "が含まれていません。\n";
	  //echo "";       	   
       }

          // var_dump($result);
       //if(in_array($data['単語'], $result)){
	//if(in_array('過去', $result)){
	//echo $data['単語'] . ':' . $data['出現ページ数'] . ':' . $data['IDF値'] . "\n";
       //}else{
	//echo '配列の中に' . $data['単語'] . 'は含まれていません' . "\n";
	//}
 	}
}


$con = mysql_close($con);
if (!$con) {
  exit('データベースとの接続を閉じられませんでした。');
}



?>
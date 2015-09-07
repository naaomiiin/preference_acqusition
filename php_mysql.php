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

$result = mysql_query('SELECT * FROM idf', $con);
while ($data = mysql_fetch_array($result)) {
  echo  $data['単語'] . ':' . $data['出現ページ数'] . ':' . $data['IDF値'] . "\n";
}

$con = mysql_close($con);
if (!$con) {
  exit('データベースとの接続を閉じられませんでした。');
}




/////////////////////////////////////////////////  mongo

// DBへ接続
$mongo = new Mongo();

// データベースを指定
$db = $mongo->selectDB("misc");

// コレクションを指定
$col = $db->selectCollection("NTT_lexical_properties");

// コレクションのドキュメントを全件取得
$cursor = $col->find();

// 表示
foreach ($cursor as $id =>$obj) {
        var_dump($obj);
}




?>

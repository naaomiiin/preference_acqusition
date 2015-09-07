<?php

$link = mysql_connect('localhost', 'klab', '0nsayken9');
if (!$link) {
    die('接続できませんでした: ' . mysql_error());
}
echo '接続に成功しました';

$result = mysql_select_db('naomi', $link);
if (!$result) {
  exit('データベースを選択できませんでした。');
}


$result = mysql_query('SELECT * FROM idf', $link);
while ($data = mysql_fetch_array($result)) {
  echo $data['単語'] . ':' . $data['出現ページ数'] . ':' . $data['IDF値'];
}





mysql_close($link);




?>
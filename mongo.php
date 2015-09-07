<?php

// DBへ接続
$mongo = new Mongo();

// データベースを指定
$db = $mongo->selectDB("misc");

// コレクションを指定
$col = $db->selectCollection("naomi");

// コレクションの指定したドキュメントを取得
$cursor = $col->find();
//$cursor = $col->find(array("inscribe" => "書道"));


// 表示
foreach ($cursor as $id =>$obj) {
        $result = array_slice($obj,-9,1);
        $slice = array_slice($obj,-13,1);
	$slice = implode($slice);
//	echo $slice;
	


        //echo $result[1] . "\n\n";
        if (implode($result) === "成金風") {
           echo "\n\n!!!!!!!!!!!!yes\n";
	   echo $slice . "\n";
	   echo "\n\n";
           } else {
           echo implode($result) . "no\n";
        }

}



?>
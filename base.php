<?php

print "\n--------- Start System ---------\n\n";
print " Sys : あなたの趣味はなんですか？\n";

$fp = fopen("title.txt", "w");
print " You : ";
fwrite($fp, rtrim(fgets(STDIN), "\n"));
fclose($fp);

$file = `mecab title.txt | grep "名詞"| cut -f 1 | uniq -c  > title_2.txt`;
$output = `cat title_2.txt | awk '{print substr($0, 9)}' > title_3.txt`;
$remove = `cat title_3.txt | sed '/もの/d'| sed '/こと/d'|sed '/私/d'| sed '/'\''/d' > title_4.txt`;
$list = file('title_4.txt');
$list = file('title_4.txt', FILE_IGNORE_NEW_LINES);

$count = count( $list );
if( $count == 2 ){
    $keyword = $list[0] . $list[1];
}else{
    $keyword = $list[0];
}

print " Sys : ". $keyword ."の何が好きですか？\n";
print " You : ";
$stdin2 = trim(fgets(STDIN));
print " Sys : いいですね\n";
print " You : ";
$stdin3 = trim(fgets(STDIN));
print "\n";



?>
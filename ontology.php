<?php

$keyword = "日本";
$keyword = mb_convert_encoding($keyword, 'UTF-8', 'auto');
$keyword = urlencode($keyword);
$json = file_get_contents("http://www.wikipediaontology.org/data/instance/".$keyword.".json");
$dec_arr=json_decode($json,true);
print_r ($dec_arr[3][5][1]);
print "\n";
?>
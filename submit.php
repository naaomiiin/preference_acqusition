<?php


if(isset($_POST['register'])) {
  $name = (int)$_POST['subject_name'];
  $age = (float)$_POST['subject_age'];
  $sex = (int)$_POST['subject_sex'];


//$data = 'Y/m/d H:i:s';

$fp = fopen("subject_name.txt", "a");
fwrite($fp, $name);
fclose($fp);

$fp = fopen("subject_age.txt", "a");
fwrite($fp, $age);
fclose($fp);

$fp = fopen("subject_sex.txt", "a");
fwrite($fp, $sex);
fclose($fp);
}


?>
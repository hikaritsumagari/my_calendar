<?php
// まず確認する
// var_dump($_POST);
// exit();

$date = $_POST['diaryDate'];
$diary = $_POST['diary'];

$write_data = "{$date} , {$diary}\n";
$file = fopen('data/diary.csv', 'a');

flock($file, LOCK_EX);
fwrite($file, $write_data);
flock($file, LOCK_UN);
fclose($file);
header("Location:diary.php");

<?php
// まず確認する
// var_dump($_POST);
// exit();

$myList = $_POST['myList'];

$write_data = "{$myList}\n";
$file = fopen('data/memo.csv', 'a');

flock($file, LOCK_EX);
fwrite($file, $write_data);
flock($file, LOCK_UN);
fclose($file);
header("Location:index.php");

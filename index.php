<?php
session_start();
$_SESSION['passport'] = $_SERVER['REMOTE_ADDR'];
$log = "VISIT FROM ".$_SERVER['REMOTE_ADDR']."\n";
$fp = fopen("logs.txt", "a");
fwrite($fp, $log);
fclose($fp);
header("location: post/index.php");
?>
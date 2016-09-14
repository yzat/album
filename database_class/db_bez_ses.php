<?php
session_start();

error_reporting(0);
ini_set('display_errors', 1);

require_once ('MysqliDb.php');
date_default_timezone_set('Asia/Bishkek');
$db = new MysqliDb ('localhost', 'root', '', 'photo_gallery');
?>


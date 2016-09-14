<?php
session_start();
if(empty($_SESSION['user'])){
    echo "<script>window.location='../index.php'</script>";
}
$ya=$_SESSION['user'];
if($ya!='i_user_in_this_website'){
    echo "<script>window.location='../index.php'</script>";
}
$user_id=@$_SESSION['user_id'];
error_reporting(0);
ini_set('display_errors', 1);

require_once ('MysqliDb.php');
date_default_timezone_set('Asia/Bishkek');
$db = new MysqliDb ('localhost', 'root', '', 'photo_gallery');

$db->where('id',$user_id);
$data=$db->getOne('admin');
$user_id=$data['id'];
//echo "<pre>";print_r($data); "</pre>";
?>


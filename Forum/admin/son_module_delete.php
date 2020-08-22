<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();
include_once 'inc/is_manage_login.inc.php';
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
	skip("son_module.php","error","id参数传递错误！");
}
if(!isset($_GET['id'])){
	exit("无id！");
}
$query = "delete from son where id = {$_GET['id']}";
execute($link, $query);
if (mysqli_affected_rows($link)==1){
	skip("son_module.php","ok","恭喜你!");
}
else {
	skip("son_module.php","error","很遗憾！");
}
?>
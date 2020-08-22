<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();
include_once 'inc/is_manage_login.inc.php';
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
	skip("father_module.php","error","id参数传递错误！");
}
$link = connect();
$query = "select * from son where father_id={$_GET['id']}";
$result = execute($link, $query);
if(mysqli_num_rows($result)){
	skip("father_module.php", 'error', "这个父板块下面还有子板块！");
}
if(!isset($_GET['id'])){
	exit("无id！");
}
$query = "delete from father where id = {$_GET['id']}";
execute($link, $query);
if (mysqli_affected_rows($link)==1){
	skip("father_module.php","ok","恭喜你!");
}
else {
	skip("father_module.php","error","很遗憾！");
}
?>
<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();
session_unset();
session_destroy();
setcookie(session_name(),'',time()-3600,'/');
if(!is_manage_login($link)){
	header('Location:login.php');
}
?>
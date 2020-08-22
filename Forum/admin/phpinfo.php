<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$title = '系统信息';
$link=connect();
include 'inc/is_manage_login.inc.php';

phpinfo();
?>
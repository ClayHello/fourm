<?php 
header('Content-type:text/html;charse=utf-8');
date_default_timezone_set('Asia/Shanghai');
session_start();
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_DATABASE','forum');
define('DB_PORT',3306);
define('S_A_PATH', dirname(dirname(__FILE__)));
// $Server_Absolute_PATH
define('SUB_URL', str_replace($_SERVER['DOCUMENT_ROOT'], '',str_replace('\\', '/', S_A_PATH)).'/');
?>
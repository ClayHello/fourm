<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$title = '欢迎登录！';
if(!is_login($link)){
	skip('index.php','error','您还没登录，怎么退出！');
}
setcookie('member[name]','',time()-3600);
setcookie('member[pw]','',time()-3600);
skip($_SERVER['HTTP_REFERER'], 'ok', '退出成功！');

	  ?>
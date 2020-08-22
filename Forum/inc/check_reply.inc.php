<?php  
$_POST = escape($link, $_POST);
if(mb_strlen($_POST['content'])<3){
	skip($_SERVER['REQUEST_URI'], 'error', '内容不得为空!');
}
?>
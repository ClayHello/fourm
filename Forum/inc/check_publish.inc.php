<?php  
$_POST = escape($link, $_POST);
if(empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
	skip('publish.php', 'error', 'id有误！');
}

$query = "select * from son where id={$_POST['module_id']}" ;
$result = execute($link, $query);
if(mysqli_num_rows($result)!=1){
	skip('publish.php', 'error', '请选择所属板块!');
}
if(mb_strlen($_POST['title'])>255){
	skip('publish.php', 'error', '标题不得超过60字符!');
}

if(empty($_POST['title'])){
	skip('publish.php', 'error', '标题不得为空!');
}
?>
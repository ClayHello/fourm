<?php 
	if (!is_numeric($_POST['father_id'])){
		skip("son_module_add.php", 'error', "父板块不得为空！");
	}
	$query = "select * from father where id ={$_POST['father_id']}";
	$result = execute($link, $query);
	if(mysqli_num_rows($result)==0){
		skip("son_module_add.php", 'error', "无此父板块！");
	}
	if(empty($_POST['name'])){
		skip("son_module_add.php", 'error', "名称未输入字符！");
	}
	if(mb_strlen($_POST['name'])>25){
		skip("son_module_add.php", 'error', "名称不得超过50个字符！");
	}
// 	$_POST=escape($link, $_POST);
	switch($check){
		case 'add':
			$query = "select * from son where name='{$_POST['name']}'";
			break;
		case 'update':
			$query = "select * from son where name='{$_POST['name']}' && id!={$_GET['id']}";
			break;
		default:
			skip("son_module_add.php", 'error', "无有效check参数！");
	}
	$result = execute($link, $query);
	if(mysqli_num_rows($result)){
		skip("son_module.php_add", 'error', "板块已存在！");
	}
	if(mb_strlen($_POST['info'])>255){
		skip("son_module.php_add", 'error', "简介不得超过255个字符！");
	}
	if(mb_strlen($_POST['sort'])>5){
		skip("son_module.php_add", 'error', "排序数组不能大于9999！");
	}
	if(!is_numeric($_POST['sort'])){
		skip("son_module.php_add", 'error', "排序请输入纯数字！");
	}
?>
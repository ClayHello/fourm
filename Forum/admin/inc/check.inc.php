<?php 
	if(empty($_POST['name'])){
		skip("father_module_add.php", 'error', "名称未输入字符！");
	}
	if(mb_strlen($_POST['name'])>25){
		skip("father_module_add.php", 'error', "名称不得超过50个字符！");
	}
	if(mb_strlen($_POST['sort'])>5){
		skip("father_module_add.php", 'error', "排序数组不能大于9999！");
	}
	if(!is_numeric($_POST['sort'])){
		skip("father_module_add.php", 'error', "排序请输入纯数字！");
	}
	$_POST=escape($link, $_POST);
	switch($check){
		case 'add':
			$query = "select * from father where name='{$_POST['name']}'";
			break;
		case 'update':
			$query = "select * from father where name='{$_POST['name']}' && id!={$_GET['id']}";
			break;
			default:
				skip("father_module_add.php", 'error', "无有效check参数！");
	}
	$result = execute($link, $query);
	if(mysqli_num_rows($result)){
		skip("father_module_add.php", 'error', "名称已存在！");
	}
?>
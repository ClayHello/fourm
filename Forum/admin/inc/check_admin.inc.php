<?php 
	if(empty($_POST['name'])){
		skip("manage_add.php", 'error', "名称未输入字符！");
	}
	if(mb_strlen($_POST['name'])>25){
		skip("manage_add.php", 'error', "名称不得超过50个字符！");
	}
	if(mb_strlen($_POST['password'])<6){
		skip("manage_add.php", 'error', "密码不得少于六位！");
	}
	$_POST=escape($link, $_POST);
	$query = "select * from manage where name='{$_POST['name']}'";
	$result = execute($link, $query);
	if(mysqli_num_rows($result)){
		skip("manage_add.php", 'error', "名称已存在！");
	}
	
	if(!isset($_POST['level']) || ($_POST['level']!=0 && $_POST['level']!=1)){
		$_POST['level']=1;
	}
?>
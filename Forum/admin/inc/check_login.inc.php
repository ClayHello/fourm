<?php 
	if(empty($_POST['name'])){
		skip("login.php", 'error', "名称未输入字符！");
	}
	if(mb_strlen($_POST['name'])>25){
		skip("login.php", 'error', "名称不得超过50个字符！");
	}
	if(mb_strlen($_POST['password'])<6){
		skip("login.php", 'error', "密码不得少于六位！");
	}
	if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
		skip('login.php', 'error', '验证码输入错误！');
	}
	
	if(!isset($_POST['level']) || ($_POST['level']!=0 && $_POST['level']!=1)){
		$_POST['level']=1;
	}
	$_POST = escape($link, $_POST);
?>
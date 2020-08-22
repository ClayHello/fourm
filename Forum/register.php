<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$title = '欢迎注册！';
if(is_login($link)){
	skip('index.php', 'error', '请勿重复登录！');
}
if(isset($_POST['submit'])){
	include_once 'inc/check_register.inc.php';
	$query="insert into member(name,password,register_time) values('{$_POST['name']}',md5('{$_POST['password']}'),now())";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		setcookie('member[name]',$_POST['name']);
		setcookie('member[pw]',sha1(md5($_POST['password'])));
		skip('index.php', 'ok', '注册成功！');
	}
	else {
		skip('register.php', 'error', '注册失败！');
	}
}

?>
<?php include_once 'inc/header.inc.php';?>
	<div id="register" class="auto">
		<h2>请注册！</h2>
		<form method="post">
			<label>用户名：<input type="text" name="name" /><span>*用户名不得为空，并且长度不得超过32个字符</span></label>
			<label>密码：<input type="password" name="password" /><span>*密码不得少于6位</span></label>
			<label>确认密码：<input type="password" name="comfirm_pw" /><span>*请输入与上面一致</span></label>
			<label>验证码：<input name="vcode" type="text" name="vcode" /><span>*请输入下方验证码</span></label>
			<img class="vcode" src="show_vcode.php" />
			<div style="clear:both;"></div>
			<input class="btn" type="submit" name="submit" value="确定注册" />
		</form>
	</div>
<?php include_once 'inc/footer.inc.php';?>
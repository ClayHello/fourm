<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$title = '欢迎登录！';
if(is_login($link)){
	skip('index.php','error','你已经登录，请不要重复登录！');
}
if(isset($_POST['submit'])){
	include_once 'inc/check_login.inc.php';
	$query = "select * from member where name='{$_POST['name']}' and password=md5('{$_POST['password']}')";
	$result = execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		setcookie('member[name]',$_POST['name'],time()+$_POST['time']);
		setcookie('member[pw]',sha1(md5($_POST['password'])),time()+$_POST['time']);
		skip('index.php', 'ok', '登录成功！');
	}
	else {
		skip('login.php', 'error', '用户名或者密码填写错误！');
	}
}
	  ?>
<?php include_once 'inc/header.inc.php';?>
	<div id="register" class="auto">
		<h2>欢迎登录</h2>
<form method="post">
			<label>用户名：<input type="text" name="name"  /><span></span></label>
			<label>密码：<input type="password" name="password"  /><span></span></label>
			<label>验证码：<input name="vcode" type="text"  /><span>*请输入下方验证码</span></label>
			<img class="vcode" src="show_vcode.php" />
			<label>自动登录：
				<select style="width:236px;height:25px;" name="time">
					<option value="3600">1小时内</option>
					<option value="86400">1天内</option>
					<option value="259200">3天内</option>
					<option value="2592000">30天内</option>
				</select>
				<span>*公共电脑上请勿长期自动登录</span>
			</label>
			<div style="clear:both;"></div>
<!-- 			<input class="btn" type="submit" name="submit" value="登录" /> -->
			<input class="btn" type="submit" name="submit" value="登录" />
		</form>
	</div>
<?php include_once 'inc/footer.inc.php';?>
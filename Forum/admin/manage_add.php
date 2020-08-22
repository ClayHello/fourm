<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$title = '管理员添加页';
$link = connect();
include_once 'inc/is_manage_login.inc.php';
if(isset($_POST['submit'])){
	include_once 'inc/check_admin.inc.php';
	$data = "insert into manage(name,password,create_time,level) values('{$_POST['name']}',md5('{$_POST['password']}'),now(),{$_POST['level']})";
	execute($link, $data);
	if(mysqli_affected_rows($link)){
		skip("manage.php", 'ok', "添加成功！");
	}
	else {
		skip("manage_add.php", 'error', "添加失败！");
	}
}
?>

<?php include_once 'inc/header.inc.php';?>
<div id="main">
	<div class="title" style="margin-bottom:20px;">添加管理员</div>
	<form action="" method="post">
		<table class="au">
				<tr>
					<td>管理员名称</td>
					<td><input name="name" type="text" /></td>
					<td>
						不得为空，最大不得超过50个字符
					</td>
				</tr>
				<tr>
					<td>密码</td>
					<td><input name="password" type="password" /></td>
					<td>
						不能少于6位
					</td>
				</tr>
				<tr>
					<td>等级</td>
					<td>
						<select name="level">
							<option value="1">普通管理员</option>
							<option value="0">超级管理员</option>
						</select>
					</td>
					<td>
						请选择一个等级
					</td>
				</tr>
			</table>
			<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
	</form>
</div>
<?php include_once 'inc/footer.inc.php';?>
<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$title = '父板块添加页'; 
$link = connect();
include_once 'inc/is_manage_login.inc.php';
if(isset($_POST['submit'])){
	$check = "add";
	include_once 'inc/check.inc.php';
	$data = "insert into father(name,sort) values('{$_POST['name']}',{$_POST['sort']})";
	execute($link, $data);
	if(mysqli_affected_rows($link)){
		skip("father_module.php", 'ok', "添加成功！");
	}
	else {
		skip("father_module_add.php", 'error', "添加失败！");
	}
}
?>
<?php include_once 'inc/header.inc.php';?>

<div id="main">
	<div class="title" style="margin-bottom:20px;">添加父板块</div>
	<form action="" method="post">
		<table class="au">
				<tr>
					<td>版块名称</td>
					<td><input name="name" type="text" /></td>
					<td>
						不得为空，最大不得超过50个字符
					</td>
				</tr>
				<tr>
					<td>排序</td>
					<td><input name="sort" value="0" type="text" /></td>
					<td>
						填数字
					</td>
				</tr>
			</table>
			<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
	</form>
</div>

<?php include_once 'inc/footer.inc.php';?>
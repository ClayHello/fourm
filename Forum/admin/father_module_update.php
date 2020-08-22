<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$title="父板块修改";
$link = connect();
include_once 'inc/is_manage_login.inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip("father_module.php", 'error', "id参数错误! ");
}
$query = "select * from father where id='{$_GET['id']}'";
$result = execute($link, $query);
if(!mysqli_num_rows($result)){
	skip("father_module.php", 'error', "版块不存在！");
}
if(isset($_POST['submit'])){
	$check="update";
	include_once 'inc/check.inc.php';
	$query="update father set name='{$_POST['name']}',sort={$_POST['sort']} where id='{$_GET['id']}'";
	execute($link, $query);
	if (mysqli_affected_rows($link)==1) {
		skip("father_module.php", 'ok', "修改成功！");
	}
	else {
		skip("father_module.php", 'error', "修改失败！");
	}
}
$data = mysqli_fetch_assoc($result);
?>


<?php include_once 'inc/header.inc.php';?>
<div id="main">
	<div class="title" style="margin-bottom:20px;">修改父板块 - <?php echo $data['name'];?></div>
	<form action="" method="post">
		<table class="au">
				<tr>
					<td>版块名称</td>
					<td><input name="name" value="<?php echo $data['name'];?>"type="text" /></td>
					<td>
						不得为空，最大不得超过50个字符
					</td>
				</tr>
				<tr>
					<td>排序</td>
					<td><input name="sort" value="<?php echo $data['sort'];?>" type="text" /></td>
					<td>
						填数字
					</td>
				</tr>
			</table>
			<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="编辑" />
	</form>
</div>
 
<?php include_once 'inc/footer.inc.php';?>
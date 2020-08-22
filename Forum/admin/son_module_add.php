<?php
	include_once '../inc/config.inc.php'; 
	include_once '../inc/mysql.inc.php';
	include_once '../inc/tool.inc.php';
	$title='子板块添加页';
	$link = connect();
	include_once 'inc/is_manage_login.inc.php';
	if(isset($_POST['submit'])){
		$check = "add";
		include_once 'inc/check_son.inc.php';
		$query = "insert into son(father_id,name,info,member_id,sort) values('{$_POST['father_id']}','{$_POST['name']}','{$_POST['info']}','{$_POST['member_id']}',{$_POST['sort']})";
		$result = execute($link, $query);
		if(mysqli_affected_rows($link)){
			skip("son_module.php", 'ok', "添加成功！");
		}
		else {
            skip("son_module_add.php", 'error', "添加失败！");
        }
	}
	
?>


<?php include_once 'inc/header.inc.php';?>
<div id='main'>
	<div class="title" style="margin-bottom:20px;">添加子板块</div>
	<form action="" method="post">
		<table class="au">
				<tr>
					<td>所属父板块</td>
					<td>
						<select name='father_id'>
							<?php 
							$query='select * from father';
							$result=execute($link, $query);
							while ($data = mysqli_fetch_assoc($result)){
								echo "<option value='{$data['id']}'>{$data['name']}</option>";
							}
							?>
						</select>
					</td>
					<td>
						必须选择一个有效的父板块！
					</td>
				</tr>
				<tr>
					<td>版块名称</td>
					<td><input name="name" type="text" /></td>
					<td>
						不得为空，最大不得超过50个字符！
					</td>
				</tr>
				<tr>
					<td>版块简介</td>
					<td>
						<textarea rows="100px" cols="200px" style="resize:none;" name="info"></textarea>
					</td>
					<td>
						不得多于255个字符！
					</td>
				</tr>
				<tr>
					<td>版主</td>
					<td>
						<select name='member_id'>
							<option value="0">请选择一个会员作为版主</option>
						</select>
					</td>
					<td>
						必须选择一个有效的会员！
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
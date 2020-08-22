<?php
	include_once '../inc/config.inc.php'; 
	include_once '../inc/mysql.inc.php';
	include_once '../inc/tool.inc.php';
	$title='子板块修改页';
	$link = connect();
	include_once 'inc/is_manage_login.inc.php';
	if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
		skip("son_module.php", 'error', "id参数错误! ");
	}
	$query = "select * from son where id='{$_GET['id']}'";
	$s_result = execute($link, $query);
	if(!mysqli_num_rows($s_result)){
		skip("son_module.php", 'error', "子版块不存在！");
	}
	$s_data = mysqli_fetch_assoc($s_result);
	if(isset($_POST['submit'])){
		$check = "update";
		include_once 'inc/check_son.inc.php';
		$query="update son set father_id='{$_POST['father_id']}',name='{$_POST['name']}',info='{$_POST['info']}',member_id={$_POST['member_id']},sort={$_POST['sort']} where id='{$_GET['id']}'";
		execute($link, $query);
		if (mysqli_affected_rows($link)==1) {
			skip("son_module.php", 'ok', "修改成功！");
		}
		else {
			skip("son_module.php", 'error', "修改失败！");
		}
	}
?>


<?php include_once 'inc/header.inc.php';?>
<div id='main'>
	<div class="title" style="margin-bottom:20px;">修改子板块 - <?php echo $s_data['name'];?></div>
	<form action="" method="post">
		<table class="au">
				<tr>
					<td>所属父板块</td>
					<td>
						<select name='father_id'>
							<?php 
							$query='select * from father';
							$f_result=execute($link, $query);
							while ($f_data = mysqli_fetch_assoc($f_result)){
								if($s_data['father_id']==$f_data['id']){
									echo "<option selected='selected' value='{$f_data['id']}'>{$f_data['name']}</option>";
								}
								else {	
								echo "<option value='{$f_data['id']}'>{$f_data['name']}</option>";
							} 
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
					<td><input name="name" value="<?php echo $s_data['name'];?>" type="text" /></td>
					<td>
						不得为空，最大不得超过50个字符！
					</td>
				</tr>
				<tr>
					<td>版块简介</td>
					<td>
						<textarea rows="" cols="" style="resize:none;" name="info"><?php echo $s_data['info'];?> </textarea>
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
					<td><input name="sort" value="<?php echo $s_data['sort'];?>" type="text" /></td>
					<td>
						填数字
					</td>
				</tr>
			</table>
			<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="编辑" />
	</form>	

</div>
<?php include_once 'inc/footer.inc.php';?>
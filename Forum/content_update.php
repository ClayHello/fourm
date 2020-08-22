<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$is_manage_login=is_manage_login($link);
$title = '帖子修改';
$member_id=is_login($link);
if(!$member_id && !$is_manage_login){
	skip('login.php','error','未登录！');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', '帖子id不合法！');
}
$query="select * from content where id={$_GET['id']}";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)==1){
	$data_content=mysqli_fetch_assoc($result_content);
	if(check_user($member_id, $data_content['member_id'], $is_manage_login)){
		if(isset($_POST['submit'])){
			include 'inc/check_publish.inc.php';
			$query="update content set module_id={$_POST['module_id']},title='{$_POST['title']}',content='{$_POST['content']}' where id={$_GET['id']}";
			execute($link, $query);
			if(isset($_GET['return_url'])){
				$return_url=$_GET['return_url'];
			}
			else{
				$return_url="member.php?id={$member_id}";
			}
			if(mysqli_num_rows($result_content)){
				skip($return_url, 'ok', '修改成功！');
			}
			else {
				skip($return_url, 'error', '修改失败！');
			}
		}
	}
	else {
		skip('index.php', 'error', '这不是你的帖子！');
	}
}
else{
	skip('index.php', 'error', '帖子不存在！');
}

$data_content['title']=htmlspecialchars($data_content ['title']);
?>
<?php include_once 'inc/header.inc.php';?> 
	<div id="position" class="auto">
		 <a href="index.php">首页</a> &gt; 修改帖子
	</div>
	<div id="publish">
		<form method="post">
			<select name="module_id">
				<?php 
				if(isset($_GET['son_id']) && !is_numeric($_GET['son_id'])){
					skip('publish.php', 'error', '别这样');
				}
				$query = "select * from father order by sort desc";
				$result_father = execute($link, $query);
				while ($data_father = mysqli_fetch_assoc($result_father)){
					echo "<optgroup label='{$data_father['name']}'>";
					$query = "select * from son where father_id={$data_father['id']} order by sort desc";
					$result_son = execute($link, $query);
					while ($data_son = mysqli_fetch_assoc($result_son)){
						if($data_content['module_id']==$data_son['id']){
							echo "<option selected='selected' value='{$data_son['id']}'>{$data_son['name']}</option>";
						}
						else{
						echo "<option value='{$data_son['id']}'>{$data_son['name']}</option>";
							}
					}
					echo "</optgroup>";
				}
				?>
			</select>
			<input class="title" placeholder="请输入标题" name="title" type="text" value="<?php echo $data_content['title']?>"/>
			<textarea name="content" class="content" ><?php echo $data_content['content']?></textarea>
			<input type="submit" name="submit" style="background-image: none;background-color:#6495ED; color:white; width:70px;height:30px; " value="修改" />
			<div style="clear:both;"></div>
		</form>
	</div>
<?php include_once 'inc/footer.inc.php';?>
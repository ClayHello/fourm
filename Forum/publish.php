<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$title = '帖子发布';
if(!$member_id=is_login($link)){
	skip('login.php', 'error', '请先登录！');
} 
if(isset($_POST['title']) && empty($_POST['title'])){
	skip("publish.php?son_id={$_POST['module_id']}", 'error', '标题不得为空！');
}
if(isset($_POST['submit'])){
	include_once 'inc/check_publish.inc.php';
	$query = "insert into content(module_id,title,content,time,member_id) values({$_POST['module_id']},'{$_POST['title']}','{$_POST['content']}',now(),{$member_id})";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip("list_son.php?id={$_POST['module_id']}", 'ok', '发布成功！');
	}
}

?>
<?php include_once 'inc/header.inc.php';?> 
	<div id="position" class="auto">
		 <a href="index.php">首页</a> &gt; 发布帖子
	</div>
	<div id="publish">
		<form method="post">
			<select name="module_id">
				<?php 
				if(isset($_GET['father_id']) && is_numeric($_GET['father_id'])){
					$where="where id={$_GET['father_id']}";
				}
				else{
					$where='';
				}
				if(isset($_GET['son_id'])){
					if(!is_numeric($_GET['son_id'])){
						skip('publish.php', 'error', '别这样');
					}
				}
				$query = "select * from father {$where} order by sort desc";
				$result_father = execute($link, $query);
				while ($data_father = mysqli_fetch_assoc($result_father)){
					echo "<optgroup label='{$data_father['name']}'>";
					$query = "select * from son where father_id={$data_father['id']} order by sort desc";
					$result_son = execute($link, $query);
					while ($data_son = mysqli_fetch_assoc($result_son)){
						if(isset($_GET['son_id'])&& $_GET['son_id']==$data_son['id']){
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
			<input class="title" placeholder="请输入标题" name="title" type="text" />
			<textarea name="content" class="content"></textarea>
			<input class="publish" type="submit" name="submit" value="" />
			<div style="clear:both;"></div>
		</form>
	</div>
<?php include_once 'inc/footer.inc.php';?>
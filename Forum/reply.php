<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$title = '帖子回复';
if(!$member_id=is_login($link)){
	skip('login.php', 'error', '请先登录！');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip("index.php", 'error', '帖子id不合法！');
}

$query="select * from content where id={$_GET['id']}";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)!=1){
	skip("index.php", 'error', '帖子不存在！');
}
$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);

$query="select * from member where id={$data_content['member_id']}";
$result_member=execute($link, $query);
if(mysqli_num_rows($result_content)!=1){
	skip("index.php", 'error', '用户不存在！');
}
$data_member=mysqli_fetch_assoc($result_member);

if(isset($_POST['submit'])){
	include_once 'inc/check_reply.inc.php';
	$query="insert into reply(content_id,content,time,member_id) values({$_GET['id']},'{$_POST['content']}',now(),{$member_id})";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip("show.php?id={$_GET['id']}", 'ok', '回复成功！');
	}
	else{
		skip($_SERVER['REQUEST_URI'], 'error', '回复失败！');
	}
}
?>
<?php include_once 'inc/header.inc.php';?> 
<div id="position" class="auto">
		 <a href="index.php">首页</a> &gt; 回复帖子  
</div>
<div id="publish">
	<div>回复：由 <?php echo $data_member['name']?> 发布的 "<?php echo $data_content['title']?>"</div>
	<form method="post">
		<textarea name="content" class="content"></textarea>
		<input class="reply" type="submit" name="submit" value="" />
		<div style="clear:both;"></div>
	</form>
</div>
<?php include_once 'inc/footer.inc.php';?>
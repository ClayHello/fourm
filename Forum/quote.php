<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$title = '引用回复';
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

if(!isset($_GET['reply_id']) || !is_numeric($_GET['reply_id'])){
	skip("index.php", 'error', '引用的回复id不合法！');
}

$query="select reply.content,member.name from reply,member where reply.id={$_GET['reply_id']} and content_id={$_GET['id']} and reply.member_id=member.id";
$result_reply=execute($link, $query);
if(mysqli_num_rows($result_reply)!=1){
	skip("index.php", 'error', '引用的帖子不存在！');
}
if(isset($_POST['submit'])){
	include_once 'inc/check_reply.inc.php';
	$_POST['content']=htmlspecialchars($_POST['content']); 
	$query="insert into reply(content_id,quote_id,content,time,member_id) values({$_GET['id']},{$_GET['reply_id']},'{$_POST['content']}',now(),{$member_id})";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip("show.php?id={$_GET['id']}", 'ok', '回复成功！');
	}
	else{
		skip($_SERVER['REQUEST_URI'], 'error', '回复失败！');
	}
}
$data_reply=mysqli_fetch_assoc($result_reply);
$data_reply['name']=htmlspecialchars($data_reply['name']);
$data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));

$query="select count(*) from reply  where content_id={$_GET['id']} and id<={$_GET['reply_id']}";
$floor = num($link, $query);


?>
<?php include_once 'inc/header.inc.php';?> 
<div id="position" class="auto">
		<a href="index.php">首页</a> &gt; 引用回复  
	</div>
	<div id="publish">
		<div>回复：由 <?php echo $data_member['name']?> 发布的 "<?php echo $data_content['title']?>"</div>
		<div class="quote">
			<p class="title">引用<?php echo $floor ?>楼 <?php echo $data_reply['name']?> 发表的内容: </p>
			" <?php echo $data_reply['content']?>"
		</div>
		<form method="post">
			<textarea name="content" class="content"></textarea>
			<input class="reply" type="submit" name="submit" value="" />
			<div style="clear:both;"></div>
		</form>
	</div>
<?php include_once 'inc/footer.inc.php';?>
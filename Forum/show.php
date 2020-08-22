<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
$member_id=is_login($link);
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', '帖子id不合法！');
}
$query="update content set times=times+1 where id={$_GET['id']}";
execute($link, $query);
$query="select * from content where id ={$_GET['id']}";
$result_content=execute($link, $query);
$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);
$data_content['content']=nl2br(htmlspecialchars($data_content['content']));
$title=$data_content['title'];

$query="select count(*) from reply where content_id={$data_content['id']} order by id desc limit 1";
$reply=num($link, $query);

if(mysqli_num_rows($result_content)!=1){
	skip('index.php', 'error', '帖子不存在！');
}
$query="select * from son where id={$data_content['module_id']}";
$result_son=execute($link, $query);
$data_son=mysqli_fetch_assoc($result_son);

$query="select * from father where id={$data_son['father_id']}";
$result_father=execute($link, $query);
$data_father=mysqli_fetch_assoc($result_father);

$query="select * from member where id={$data_content['member_id']}";
$result_member=execute($link, $query);
$data_member=mysqli_fetch_assoc($result_member);
$data_member['name']=htmlspecialchars($data_member['name']);
?>
<?php include_once 'inc/header.inc.php';?>
	<div id="position" class="auto">
		 <a href="index.php">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['name']?></a> &gt; <a href="list_son.php?id=<?php echo $data_son['id']?>"><?php echo $data_son['name']?></a> &gt; <?php echo $data_content['title']?>
	</div>
	<div id="main" class="auto">
		<div class="wrap1">
			<div class="pages">
			<?php 
			$query="select count(*) from reply where content_id={$_GET['id']}";
			$count_reply=num($link, $query);
			$page_size=5;
			$page = page($count_reply, $page_size);
			echo $page['html'];
			?>
			</div>
			<a class="btn reply" href="reply.php?id=<?php echo $_GET['id']?>"></a>
			<div style="clear:both;"></div>
		</div>
		<?php 
		if($_GET['page']==1){
		?>
		<div class="wrapContent">
			<div class="left">
				<div class="face">
					<a target="_blank" href="member.php?id=<?php echo $data_member['id']?>">
						<img style="height:45px;" src="<?php if($data_member['photo']!=''){echo $data_member['photo'];}else {echo 'style/2374101_middle.jpg';}?>" />
					</a>
				</div>
				<div class="name">
					<a href=""><?php echo $data_member['name']?></a>
				</div>
			</div>
			<div class="right" style="height: 200px">
				<div class="title">
					<h2><?php echo $data_content['title']?></h2>
					<span>阅读：<?php echo $data_content['times']?>&nbsp;|&nbsp;回复：<?php echo $reply?></span>
					<div style="clear:both;"></div>
				</div>
				<div class="pubdate">
					<span class="date">发布于：<?php echo $data_content['time']?></span>
					<span class="floor" style="color:red;font-size:14px;font-weight:bold;">楼主</span>
				</div>
				<div class="content">
					 <?php echo $data_content['content']?>
				</div>
			</div>
			<div style="clear:both;"></div>
		</div>
		
		<?php 	
		}
		?>
			<?php 
			 $query="select r.id,r.quote_id,r.member_id,r.time,r.content,m.id mid,m.photo,m.name from reply r,member m where content_id={$_GET['id']} and r.member_id=m.id order by id asc {$page['limit']}";
			 $result_reply=execute($link, $query);
			 $floor=($_GET['page']-1)*$page_size+1;
			 
			 while($data_reply=mysqli_fetch_assoc($result_reply)){
				$data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
				$data_reply['name']=htmlspecialchars($data_reply['name']);
		?>
		<div class="wrapContent">
			<div class="left">
				<div class="face">
					<a target="_blank" href="member.php?id=<?php echo $data_reply['mid']?>">
						<img style="height:45px;"src="<?php if($data_member['photo']!=''){echo $data_member['photo'];}else {echo 'style/2374101_middle.jpg';}?>" />
					</a>
				</div>
				<div class="name">
					<a href=""><?php echo $data_reply['name']?></a>
				</div>
			</div>
			<div class="right" style="height: 200px">
				
				<div class="pubdate">
					<span class="date">回复时间：<?php echo $data_reply['time']?></span>
					<span class="floor"><?php echo $floor++?>楼&nbsp;|&nbsp;<a href="quote.php?id=<?php echo $_GET['id']?>&reply_id=<?php echo $data_reply['id']?>">引用</a></span>
				</div>
				<div class="content">
				<?php 
					if($data_reply['quote_id']){
					$query="select reply.content,member.name from reply,member where reply.id={$data_reply['quote_id']} and reply.member_id=member.id";
					$result_quote=execute($link, $query);
					$data_quote=mysqli_fetch_assoc($result_quote);
					$data_quote['name']=htmlspecialchars($data_quote['name']);
					$data_quote['content']=nl2br(htmlspecialchars($data_quote['content']));
					$query="select count(*) from reply  where content_id={$_GET['id']} and id<={$data_reply['quote_id']}";
					$floor = num($link, $query);
				?>
				<div class="quote">
					<p class="title">引用<?php echo $floor?>楼 <?php echo $data_quote['name']?> 发表的: </p>
					<?php echo $data_quote['content']?>
				</div>
				<?php }?>
					<?php echo $data_reply['content']?>
				</div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<?php }?>
		<div class="wrap1">
			<div class="pages">
			<?php echo $page['html'];?>
			</div>
			<a class="btn reply" href="reply.php?id=<?php echo $_GET['id']?>"></a>
			<div style="clear:both;"></div>
		</div>
	</div>
<?php include_once 'inc/footer.inc.php';?>
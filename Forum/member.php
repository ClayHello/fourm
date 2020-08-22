<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
$is_manage_login=is_manage_login($link);
$title = '会员中心';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', '会员id不合法！');
}
$query="select * from member where id={$_GET['id']}";
$result_member=execute($link, $query);
if(mysqli_num_rows($result_member)!=1){
	skip('index.php', 'error', '会员不存在！');
}
$data_member=mysqli_fetch_assoc($result_member);
$data_member['name']=htmlspecialchars($data_member['name']);
?>
<?php include_once 'inc/header.inc.php';?> 
	<div style="margin-top:55px;"></div>
	<div id="position" class="auto">
		<a href="index.php">首页</a> &gt; <?php echo $data_member['name']?>
	</div>
	<div id="main" class="auto">
		<div id="left">
			<ul class="postsList">
				<?php 
				$query="select count(*) from content where member_id={$_GET['id']}";
				$all=num($link, $query);
				$query="select count(*) from reply where content_id={$_GET['id']}";
				$count_reply=num($link, $query);
				$page_size=5;
				$page = page($all, $page_size);
				$query = "select content.title,content.id,content.time,content.times,member.id m_id,member.name,member.photo from content,member
				where content.member_id = {$_GET['id']}
				and content.member_id=member.id order by id desc {$page['limit']}";
				$result_content=execute($link, $query);
				while ($data_content=mysqli_fetch_assoc($result_content)){
				$query="select * from reply where content_id={$data_content['id']} order by id desc limit 1";
				$result_last=execute($link, $query);
				if(mysqli_num_rows($result_last)==0){
					$last_time='无';
				}
				else{
					$data_last=mysqli_fetch_assoc($result_last);
					$last_time=$data_last['time'];
				}
				$data_content['title']=htmlspecialchars($data_content['title']);
				$query="select count(*) from reply where content_id={$data_content['id']} order by id desc limit 1";
				$reply=num($link, $query);
				?>
				<li>
					<div class="smallPic">
						<img width="45" height="45" src="<?php if($data_content['photo']!=''){echo SUB_URL.$data_content['photo'];}else {echo 'style/2374101_small.jpg';}?>" />
					</div>
					<div class="subject">
						<div class="titleWrap"><h2><a target="_blank" href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
						<p>
						<?php 
							if(check_user($member_id, $data_content['m_id'], $is_manage_login)){
							$url = urlencode("content_delete.php?id={$data_content['id']}");
							$return_url = urldecode($_SERVER['REQUEST_URI']);
							$message = "你真的要删除帖子 {$data_content['title']} 吗？";
							$delete_url = "confirm.php?url={$url}&&return_url={$return_url}&&message={$message}";
						?>
								<a target='_blank' href='content_update.php?id=<?php echo $data_content['id']?>'>编辑</a> | <a href='<?php echo $delete_url?>'>删除</a>
						<?php }?>
							发布日期：<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo $last_time?>
						</p>
					</div>
					<div class="count">
						<p>
							回复<br /><span><?php echo $reply?></span>
						</p>
						<p>
							浏览<br /><span><?php echo $data_content['times']?></span>
						</p>
					</div>
					<div style="clear:both;"></div>
				</li>
				<?php }?>
			</ul>
			<div class="pages">
			<?php 
			echo $page['html'];
			?>
			</div>
		</div>
		<div id="right">
			<div class="member_big">
				<dl>
					<dt>
						<img width="180" height="180" src="<?php if($data_member['photo']!=''){echo SUB_URL.$data_member['photo'];}else {echo 'style/2374101_small.jpg';}?>" />
					</dt>
					<dd class="name"><?php echo $data_member['name']?></dd>
					<dd>帖子总计：<?php echo $all?></dd>
					<?php if(check_user($member_id, $data_member['id'], $is_manage_login)){?>
					<dd>操作：<a target="_blank" href="member_photo_update.php">修改头像</a> <!--  | <a target="_blank" href="">修改密码</a></dd> -->
					<?php }?>
				</dl>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<?php include_once 'inc/footer.inc.php';?>	

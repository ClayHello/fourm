<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
// if(!$member_id=is_login($link)){
// 	skip('login.php', 'error', '请先登录！');
// }     浏览无需登录
$member_id=is_login($link);
$is_manage_login=is_manage_login($link);

if(!isset($_GET['keyword'])){
	$_GET['keyword']='';
}
$_GET['keyword']=trim($_GET['keyword']);
$_GET['keyword']=escape($link, $_GET['keyword']);
// if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
// 	skip('index.php', 'error', 'id不合法！'); 
// }
$title='搜索页';

$query="select count(*) from content where title like '%{$_GET['keyword']}%'";
$count_all=num($link, $query);
?>
<?php include_once 'inc/header.inc.php';?>
<div id="position" class="auto">
		 <a href="index.php">首页</a> &gt;搜索页
	</div>
	<div id="main" class="auto">
		<div id="left">
			<div class="box_wrap">
				<h3> 共有<?php echo $count_all?>条匹配的记录</h3>
				</div>
				<div class="pages_wrap">
					<div class="pages">
					<?php 
					$page=page($count_all, 5, 5);
					echo $page['html'];
					?>
					</div>
					<div style="clear:both;"></div>
				</div>
			<div style="clear:both;"></div>
			<ul class="postsList">
				<?php 
				$query = "select content.title,content.id,content.time,content.times,member.id m_id,member.name,member.photo from content,member
				where content.title like '%{$_GET['keyword']}%'
				and content.member_id=member.id order by id desc
				{$page['limit']}";
				$result_content = execute($link, $query);
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
					
				$query="select count(*) from reply where content_id={$data_content['id']} order by id desc limit 1";
				$reply=num($link, $query);
				$data_content['title']=htmlspecialchars($data_content['title']);
				$data_content['name']=htmlspecialchars($data_content['name']);
// 				str_replace($_GET['keyword'], "<span style='color:red;'>{$_GET['keyword']}</span>", $data_content['title']);
				$data_content['search_title']=str_replace($_GET['keyword'], "<span style='color:red;'>{$_GET['keyword']}</span>", $data_content['title']);
				?>
				<li>
					<div class="smallPic">
						<a target="_blank" href="member.php?id=<?php echo $data_content['m_id']?>">
							<img width="45" height="45"src="<?php if($data_content['photo']!=''){echo SUB_URL.$data_content['photo'];}else {echo 'style/2374101_small.jpg';}?>">
						</a>
					</div>
					<div class="subject">
						<div class="titleWrap">&nbsp;&nbsp;<h2><a href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['search_title']?></a></h2></div>
						<p>
							楼主：<?php echo $data_content['name']?>&nbsp;发布于 <?php echo $data_content['time']?><br/>最后回复：<?php echo $last_time?><br/>
						<?php 
							if(check_user($member_id, $data_content['m_id'], $is_manage_login)){
							$return_url = urldecode($_SERVER['REQUEST_URI']);
							$url = urlencode("content_delete.php?id={$data_content['id']}&return_url={$return_url}");
							$message = "你真的要删除帖子 {$data_content['title']} 吗？";
							$delete_url = "confirm.php?url={$url}&&return_url={$return_url}&&message={$message}";
						?>
								<a target='_blank' href='content_update.php?id=<?php echo $data_content['id']?>&return_url=<?php echo $return_url?>'>编辑</a> | <a href='<?php echo $delete_url?>'>删除</a>
						<?php }?>
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
			<div class="pages_wrap">
				<div class="pages">
					<?php 
					echo $page['html'];
					?>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div id="right">
			<div class="classList">
				<div class="title">版块列表</div>
				<ul class="listWrap">
				<?php 
				$query = "select * from father";
				$result_father=execute($link, $query);
				while ($data_father=mysqli_fetch_assoc($result_father)){
				?>
					<li>
						<h2><a href="list_father.php?id=<?php echo $data_father['id'];?>"><?php echo $data_father['name']?></a></h2>
						<ul>
						<?php 
						$query_son = "select * from son where father_id={$data_father['id']}";
						$result_son=execute($link, $query_son);
						while ($data_son=mysqli_fetch_assoc($result_son)){
						?>
							<li><h3><a href="list_son.php?id=<?php echo $data_son['id']?>"><?php echo $data_son['name']?></a></h3></li>
						<?php }?>
						</ul>
					</li>
				<?php }?>
				</ul>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
	
<?php include_once 'inc/footer.inc.php';?>
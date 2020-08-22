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
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', 'error', 'id不合法！');
}

$query = "select * from father where id={$_GET['id']}";
$result_father = execute($link, $query);
if(mysqli_num_rows($result_father)==0){
	skip('index.php', 'error', '无此父板块！');
}
$data_father = mysqli_fetch_assoc($result_father);
$title = $data_father['name'];

$query = "select * from son where father_id={$_GET['id']}";
$result_son = execute($link, $query);
$id_son="";
$son_list='';
while ($data_son=mysqli_fetch_assoc($result_son)){
	$id_son.=$data_son['id'].',';
	$son_list.="<a href='list_son.php?id={$data_son['id']}'>{$data_son['name']}</a>&nbsp";
}
$id_son = trim($id_son,',');
if($id_son==''){
	$id_son='0';
}
$query = "select count(*) from content where module_id in({$id_son})";
$count_all = num($link, $query);
$query = "select count(*) from content where module_id in({$id_son}) and time>=CURDATE()";
$count_today = num($link, $query);
?>

<?php include_once 'inc/header.inc.php';?>

	<div id="position" class="auto">
		 <a href="index.php">首页</a> &gt; <span style="color: #666;"><?php echo $data_father['name']?></span>
	</div>
	<div id="main" class="auto">
		<div id="left">
			<div class="box_wrap">
				<h3><?php echo $data_father['name']?></h3>
				<div class="num">
				    今日：<span><?php echo $count_today;?></span>&nbsp;&nbsp;&nbsp;
				    总帖：<span><?php echo $count_all;?></span>
				  <div class="moderator"> 子版块： <?php echo $son_list;?></div>
				</div>
				<div class="pages_wrap">
					<a class="btn publish" href="publish.php?father_id=<?php echo $data_father['id']?>"></a>
					<div class="pages">
						<?php
							$page=page($count_all, 5, 5);
							echo $page['html'];	
						?>
					</div>
					<div style="clear:both;"></div>
				</div>
			</div>
			<div style="clear:both;"></div>
			<ul class="postsList">
			<?php 
			$query = "select content.title,content.module_id,content.id,content.time,content.times,member.id m_id,member.name,member.photo,son.name s_name from content,son,member 
			where content.module_id in ({$id_son}) 
			and content.member_id=member.id 
			and content.module_id=son.id order by id desc {$page['limit']}";
			$result_content = execute($link, $query);
			while ($data_content=mysqli_fetch_assoc($result_content)){
			$data_content['title']=htmlspecialchars($data_content['title']);
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
			$data_content['name']=htmlspecialchars($data_content['name']);
			?>
				<li>
					<div class="smallPic">
						<a target="_blank" href="member.php?id=<?php echo $data_content['m_id']?>">
							<img width="45" height="45"src="<?php if($data_content['photo']!=''){echo SUB_URL.$data_content['photo'];}else {echo 'style/2374101_small.jpg';}?>" />
						</a>
					</div>
					<div class="subject">
						<div class="titleWrap"><a href="list_son.php?id=<?php echo $data_content['module_id']?>">[<?php echo $data_content['s_name']?>]</a>&nbsp;&nbsp;<h2><a href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
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
				<a class="btn publish" href="publish.php?father_id=<?php echo $data_father['id']?>"></a> 	
				<div class="pages">
					<?php echo $page['html']?>
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
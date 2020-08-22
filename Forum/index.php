<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$title = '首页';
// if(!$member_id=is_login($link)){
// 	skip('login.php', 'error', '请先登录！');
// }   访问主页不用登录
$member_id=is_login($link);
?>
<?php include_once 'inc/header.inc.php';?> 
<div id="hot" class="auto">
	<div class="title">热门动态</div>
	<ul class="newlist">
		<!-- 20条 -->
		<li><a href="#">[唐诗]</a> <a href="#">李白太浪漫了</a></li>
		
	</ul>
	<div style="clear:both;"></div>
</div>
<?php 
$query = "select * from father order by sort desc";
$result_father=execute($link, $query);
while ($data_father=mysqli_fetch_assoc($result_father)){
?>
	<div class="box auto">
	<div class="title">
		<a href="list_father.php?id=<?php echo $data_father['id']?>" style="color: #105cb6"><?php echo $data_father['name']?></a>
	</div>
	<div class="classList">
	<?php
	 $query = "select * from son where father_id={$data_father['id']}";
	 $result_son=execute($link, $query);
	 if (mysqli_num_rows($result_son)){
		while ($data_son=mysqli_fetch_assoc($result_son)){	
		$query = "select count(*) from content where module_id={$data_son['id']} and time >= CURDATE()";
		$num = num($link, $query);	
		$query = "select count(*) from content where module_id={$data_son['id']}";
		$count_all = num($link, $query);
	$html =<<<A
		<div class="childBox new">
			<h2><a href="list_son.php?id={$data_son['id']}">{$data_son['name']}</a> <span>(今日 {$num})</span></h2>
			<br />帖子数量：{$count_all}<br />
		</div>
A;
		echo $html;
	 	}
	 }else {
		echo "<div style='padding:10px 0;'>暂无子版块...</div>";
		}
	?>
		<div style="clear:both;"></div>
	</div>
</div>
<?php }?>
<?php include_once 'inc/footer.inc.php';?>
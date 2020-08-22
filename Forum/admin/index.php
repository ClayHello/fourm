<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$title = '系统信息';
$link=connect();
include 'inc/is_manage_login.inc.php';


?>
<?php include 'inc/header.inc.php';?>
<?php 
$query="select * from manage where id={$_SESSION['manage']['id']}";
$result_manage=execute($link, $query);
$data_manage=mysqli_fetch_assoc($result_manage);
if($data_manage['level']==0){
	$data_manage['level']='超级管理员';
}
else{
	$data_manage['level']='普通管理员';
}

$query="select count(*) from father";
$count_father=num($link, $query);

$query="select count(*) from son";
$count_son=num($link, $query);

$query="select count(*) from content";
$count_content=num($link, $query);

$query="select count(*) from reply";
$count_reply=num($link, $query);

$query="select count(*) from member";
$count_member=num($link, $query);

$query="select count(*) from manage";
$count_manage=num($link, $query);
?>
<div id="main">
	<div class="title">系统信息</div>
	<div class="explain">
		<ul>
			<li>|- 您好，<?php echo $_SESSION['manage']['name']?></li>
			<li>|- 所属角色：<?php echo $data_manage['level']?> </li>
			<li>|- 创建时间：<?php echo $data_manage['create_time']?></li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|- 父版块(<?php echo $count_father?>) 子板块(<?php echo $count_son?>) 帖子(<?php echo $count_content?>) 回复(<?php echo $count_reply?>) 会员(<?php echo $count_member?>) 管理员(<?php echo $count_manage?>)</li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>|- 服务器操作系统：<?php echo PHP_OS?> </li>
			<li>|- 服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE']?> </li>
			<li>|- MySQL 版本：<?php echo mysqli_get_server_info($link)?></li>
			<li>|- 最大上传文件：<?php echo ini_get('upload_max_filesize')?></li>
			<li>|- 内存限制：<?php echo ini_get('memory_limit')?></li>
			<li>|- <a target="_blank" href="phpinfo.php">PHP 配置信息</a></li>
		</ul>
	</div>
	
	<div class="explain">
		<ul>
			<li>|- 程序安装位置(绝对路径)：<?php echo S_A_PATH?></li>
			<li>|- 程序在web根目录下的位置(首页的url地址)：<?php echo SUB_URL?></li>
			<li>|- 程序版本：sfkbbs V1.0 <a target="_blank" href="http://www.sifangku.com">[查看最新版本]</a></li>
			<li>|- 程序作者：Hello </li>
			<li>|- 网站：<a target="_blank" href="https://www.clayhello.cn">www.clayhello.cn</a></li>
		</ul>
	</div>
</div>
<?php include 'inc/footer.inc.php';?>
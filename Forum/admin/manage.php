<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$title = '管理员列表页';
$link = connect();
include_once 'inc/is_manage_login.inc.php';
?>

<?php include_once 'inc/header.inc.php';?>
<div id="main" style="">
		<div class="title">管理员页</div>
		<form action="" method="post">
		<table class="list">
			<tr>
				<th>名称</th>	 	 	
				<th>等级</th>
				<th>创建日期</th>
				<th>操作</th>
			</tr>
			<?php 
			$query = 'select * from manage';
			$result = execute($link, $query);
			while($data = mysqli_fetch_assoc($result)){	
			if($data['level']==0){
				$data['level']='超级管理员';
			}
			else{
				$data['level']='普通管理员';
			}
			$url = urlencode("manage_delete.php?id={$data['id']}");
			$return_url = urlencode($_SERVER['REQUEST_URI']);
			$message = "你真的要删除管理员{$data['name']}吗？";
			$delete_url = "confirm.php?url={$url}&&return_url={$return_url}&&message={$message}";
$html=<<<Start
				<tr>
				<td>{$data['name']}</td>
				<td>{$data['level']}</td>
				<td>{$data['create_time']}</td>
				<td><a href="{$delete_url}">[删除]</a></td>
				</tr>
Start;
				echo $html; 
			}
			?>
		</table>
		</form>
</div>
<?php include_once 'inc/footer.inc.php';?>
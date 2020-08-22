<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$title = '子板块列表页';
// 	error_reporting(0);
	$link = connect();
	include_once 'inc/is_manage_login.inc.php';
	if(isset($_POST['submit'])){
		foreach ($_POST['sort'] as $key=>$val){
			if(!is_numeric($val)||!is_numeric($key)){
				skip('son_module.php', 'error', '排序参数不合法！');
			}
			$query[] = "update son set sort={$val} where id={$key}";
		}
		// 		$data = execute($link, $query);
		if(execute_multi($link, $query, $error)){
			skip('son_module.php', 'ok', '排序成功！');
		}
		else {
			skip('son_module.php', 'error', $error);
		}
	}
// 	$query = 'select count(*) from father';
	
// 	$a = array(
// 		0 => 'hello',
// 		1 => 18	
// 	);
// 	echo $a[0];
	//数组如何传入函数？
?>

<?php include 'inc/header.inc.php';?>
<div id="main" style="">
		<div class="title">子板块页</div>
		<form action="" method="post">
		<table class="list">
			<tr>
				<th>排序</th>	 	 	
				<th>版块名称</th>
				<th>所属父板块</th>
				<th>版主</th>
				<th>操作</th>
			</tr>
			<?php 
			$query = 'select son.id,son.sort,son.name,father.name father_name,son.member_id from son,father where son.father_id=father.id order by father_id';
			$result = execute($link, $query);
			while($data = mysqli_fetch_assoc($result)){		
			$url = urlencode("son_module_delete.php?id={$data['id']}");
			$return_url = urldecode($_SERVER['REQUEST_URI']);
			$message = "你真的要删除子板块{$data['name']}吗？";
			$delete_url = "confirm.php?url={$url}&&return_url={$return_url}&&message={$message}";
$html=<<<Start
				<tr>
				<td><input class="sort" type="text" name="sort[{$data['id']}]" value="{$data['sort']}"/></td>
				<td>{$data['name']}[id:{$data['id']}]</td>
				<td>{$data['father_name']}</td>
				<td>{$data['member_id']}</td>
				<td><a href="#">[访问]</a>&nbsp;&nbsp;<a href="son_module_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="$delete_url">[删除]</a></td>
				</tr>
Start;
				echo $html; 
			}
			?>
		</table>
		<input style="margin-top: 20px;cursor:pointer;" class="btn" type="submit" name="submit" value="排序" />
		</form>
</div>
<?php include 'inc/footer.inc.php';?>	  
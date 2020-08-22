 <?php 
if(!is_manage_login($link)){
	header('Location:login.php');
	exit;
}
if(basename($_SERVER['SCRIPT_NAME'])=='manage_delete.php' || basename($_SERVER['SCRIPT_NAME'])=='manage_add.php' || basename($_SERVER['SCRIPT_NAME'])=='manage.php'){
	if($_SESSION['manage']['level']!=0){
		if(isset($_SERVER['HTTP_REFERER'])){
		skip('father_module.php', 'error', "很遗憾，你没有权限");
		}
		else{
		skip('index.php', 'error', "很遗憾，你没有权限");
		}
	}
}
?>
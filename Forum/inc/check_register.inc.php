 <?php 
 header("Content-Type: text/html;charset=utf-8");
 include_once 'inc/config.inc.php';
 include_once 'inc/mysql.inc.php';
 include_once 'inc/tool.inc.php';
 if(empty($_POST['name'])){
 	skip('register.php', 'error', '用户名不得为空！');
 }
 if(mb_strlen($_POST['name'])>32){
 	skip('register.php', 'error', '用户名不要超过32位');
 }
 if(mb_strlen($_POST['password'])<6){
 	skip('register.php', 'error', '密码不得为空且需大于6位！');
 }
 if($_POST['password']!=$_POST['comfirm_pw']){
 	skip('register.php', 'error', '密码不一致！');
 }
 
 if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
 	skip('register.php', 'error', '验证码输入错误！');
 }
 $_POST = escape($link, $_POST);
 $query = "select * from member where name='{$_POST['name']}'";
 $result = execute($link, $query);
 if(mysqli_num_rows($result)==1){
 	skip('register.php', 'error', '用户名已经被注册！');
 }
 ?>
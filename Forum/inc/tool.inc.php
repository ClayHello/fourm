 <?php 
 	function skip($url,$pic,$message){
$html = <<<Start
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>后台界面</title>
<meta name="keywords" content="后台界面" />
<meta name="description" content="后台界面" />

<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic {$pic}"></span> {$message}<a href="{$url}">5秒后自动跳转！</a></div>
</body>
</html>
Start;
echo $html;
exit();
 	}
 	//验证前台登录↓↓↓↓↓
    function is_login($link){
 		if(isset($_COOKIE['member']['name']) && isset($_COOKIE['member']['pw'])){
 			$query = "select * from member where name='{$_COOKIE['member']['name']}' && sha1(password)='{$_COOKIE['member']['pw']}'";
 			$result = execute($link, $query);
			if(mysqli_num_rows($result)){
				$data = mysqli_fetch_assoc($result);
				return $data['id'];
			}
			else {
				return false;
			} 		
 		}
 		else {
 			return false;
 		}
 	}
 	
 	function check_user($member_id,$content_member_id, $is_manage_login){
 		if($member_id==$content_member_id || $is_manage_login){
 			return true;
 		}
 		else {
 			return false;
 		}
 	}
 	//验证后台登录↓↓↓↓↓
 	function is_manage_login($link){
 		if(isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['password'])){
 			$query = "select * from manage where name='{$_SESSION['manage']['name']}' && sha1(password)='{$_SESSION['manage']['password']}'";
 			$result = execute($link, $query);
 			if(mysqli_num_rows($result)){
 				$data = mysqli_fetch_assoc($result);
 				return true;
 			}
 			else {
 				return false;
 			}
 		}
 	}
 ?>
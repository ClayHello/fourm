<?php 
$query="select * from info where id=1";
$result_info=execute($link, $query);
$data_info=mysqli_fetch_assoc($result_info);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo $title;?>--<?php echo $data_info['title']?></title>
<meta name="keywords" content="<?php echo $data_info['keywords']?>" />
<meta name="description" content="<?php echo $data_info['description']?>" />
<link rel="stylesheet" type="text/css" href="style/public.css" />
<link rel="stylesheet" type="text/css" href="style/register.css" />
<link rel="stylesheet" type="text/css" href="style/publish.css" />
<link rel="stylesheet" type="text/css" href="style/index.css" />
<link rel="stylesheet" type="text/css" href="style/list.css" />
<link rel="stylesheet" type="text/css" href="style/show.css" />
<style type="text/css">
#main #right .member_big {
	margin:20px auto 0 auto;
	width:180px;
}
#main #right .member_big dl dd {
	line-height:150%;
}
#main #right .member_big dl dd a {
	color:#333;
}
#main #right .member_big dl dd.name {
	font-size: 22px;
    font-weight: 400;
    line-height:140%;
    padding:5px 0 10px 0px;
}
</style>
</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo">poem</div>
			<div class="nav">
				<a class="hover" href="index.php">首页</a>
			</div>
			<div class="serarch">
				<form action="search.php" method="get">
					<input class="keyword" type="text" name="keyword" value="<?php if(isset($_GET['keyword']))echo $_GET['keyword']?>" placeholder="输入你想查找的标题" />
					<input class="submit" type="submit" name="submit" value="" />
				</form>
			</div>
			<div class="login">
			<?php
			if ($member_id=is_login($link)) {
			$name=htmlspecialchars($_COOKIE['member']['name']);
				$str=<<<A
 				<sapn style="color:#fff;">您好！<a target="_blank" href="member.php?id={$member_id}">{$name}</a></span> <span style="color:#fff;"> | </span><a href="logout.php">退出</a>
A;
				echo $str;
			}else {
				$str=<<<A
				<a href="login.php">登录</a>&nbsp;
				<a href="register.php">注册</a>	
A;
				echo $str;
			}
				?>

			</div>
		</div>
	</div>
	<div style="margin-top:55px;"></div>
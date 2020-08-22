<?php 
header("Content-type:text/html;charset=utf-8");
function upload($save_path,$custom_upload_max_filesize,$key,$type=array('jpg','jpeg','gif','png','txt')){
	$return_data=array();
	
	$phpini=ini_get('upload_max_filesize');
	$phpini_unit=strtoupper(substr($phpini, -1));
	$phpini_number=substr($phpini, 0,-1);
	$phpini_multiple=get_multiple($phpini_unit);
	$phpini_bytes=$phpini_number*$phpini_multiple;
	
	$custom_unit=strtoupper(substr($custom_upload_max_filesize, -1));
	$custom_number=substr($custom_upload_max_filesize, 0,-1);
	$custom_multiple=get_multiple($custom_unit);
	$custom_bytes=$custom_number*$custom_multiple;
	
	if($custom_bytes>$phpini_bytes){
		$return_data['error']='传输的文件太大!';
		$return_data['return']=false;
		return $return_data;
	}
	$arr_error=array(
		0=>'没有错',
		1=>'文件超过php.ini中upload_max_filesize的值',
		2=>'上传文件超过HTML...',
		3=>'文件只有部分上传',
		4=>'没有文件上传',
		6=>'找不到临时文件夹',
		7=>'文件写入失败'	
	);
	if(!isset($_FILES[$key]['error'])){
		$return_data['error']='不存在';
		$return_data['return']=false;
		return $return_data;
	}
	if($_FILES[$key]['error']!=0){
		$return_data['error']=$arr_error[$_FILES[$key]['error']];
		$return_data['return']=false;
		return $return_data;
	}
	
	if (!is_uploaded_file($_FILES[$key]['tmp_name'])){
		$return_data['error']='上传的文件不是通过HTTPPOSTT方式上传的';
		$return_data['return']=false;
		return $return_data;
	}
	
	if($_FILES[$key]['size']>$custom_bytes){
		$return_data['error']='超过限定大小';
		$return_data['return']=false;
		return $return_data;
	}
	
	$arr_filename=pathinfo($_FILES[$key]['name']);
	if(!isset($arr_filename['extension'])){
		$arr_filename['extension']='';
	}
	$arr_filename['extension']=strtolower($arr_filename['extension']);
	if(!in_array($arr_filename['extension'], $type)){
		$return_data['error']='上传的类型必须是'.implode(',', $type);
		$return_data['return']=false;
		return $return_data;
	}
	if(!file_exists($save_path)){
		if(!mkdir($save_path,0777,true)){
			$return_data['error']='目录创建失败 ';
			$return_data['return']=false;
			return $return_data;
		}
	}
	
	$new_filename=str_replace('.', '', uniqid(mt_rand(10000, 99999),true));
	if($arr_filename['extension']!=''){
		$new_filename.=".{$arr_filename['extension']}";
	}
	$save_path=rtrim($save_path,'/').'/';
	if(!move_uploaded_file($_FILES[$key]['tmp_name'], $save_path.$new_filename)){
		$return_data['error']='临时文件移动失败';
		$return_data['return']=false;
		return $return_data;
	}
		$return_data['save_path']=$save_path.$new_filename;
		$return_data['filename']=$new_filename;
		$return_data['return']=true;
		return $return_data;
	}
	
	function get_multiple($unit){
		switch ($unit){
			case 'K':
				$multiple=1024;
				return $multiple;
			case 'M':
				$multiple=1024*1024;
				return $multiple;
			case 'G':
				$multiple=1024*1024*1024;
				return $multiple;
			default:return false;
		}
	}

	if(isset($_POST['submit'])){
		$upload=upload('a/b/c','2M','myfile');
		if(!$upload['return']){
			echo $upload['error'];
		}
		else{
			echo '上传成功';
		}
	}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>上传页面</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="myfile" />
	<input type="submit" name="submit" value="开始上传" />
</form>
</body>
</html>
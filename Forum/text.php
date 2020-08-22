<?php 
header("Content-type:text/html;charset=utf-8");
function page($count,$page_size,$num_btn=10,$page='page'){
	if(!isset($_GET[$page])||!is_numeric($_GET[$page])||$_GET[$page]<1){
		$_GET['page']=1;
	}
	$page_all=ceil($count/$page_size);
	if($_GET[$page]>$page_all){
		$_GET[$page]=$page_all;
	}
	echo "当前页   {$_GET[$page]}<br/>";
	$start=($_GET[$page]-1)*$page_size;
	$limit="limit {$start},{$page_size}";
	$current_url=$_SERVER['REQUEST_URI'];
	$arr_current=parse_url($current_url);
	$current_path=$arr_current['path'];
	$current_query=$arr_current['query'];
	$url="";
	if(isset($arr_current['query'])){

		parse_str($arr_current['query'],$current_query);
		unset($current_query['page']);   
		if(empty($current_query)){
			$url="{$current_path}?page=";
		}
		else{
			$others=http_build_query($current_query);
			$url="{$current_path}?{$others}&page=";
		}
	}
	else{
		$url="{$current_path}?page=";
	}
	echo $url;
	$html=array();
	if($num_btn>=$page_all){
		for($i=1;$i<=$page_all;$i++){
			if($_GET[$page]==$i){
				$html[$i]="<span>{$i}</span> ";
			}
			else{
			$html[$i]="<a href='{$url}{$i}'>{$i}</a> ";
			}
		}
	}
	else{
		$num_left = floor(($num_btn-1)/2);
		$start =$_GET[$page]-$num_left;
		$end=$start+($num_btn-1);
		if($start<1){
			$start=1;
		}
		if($end>$page_all){
			$start= $page_all-$num_btn+1;
		}
		for($i=0;$i<$num_btn;$i++){
			if($_GET[$page]==$start){
				$html[$start]="<span>{$start}</span> ";
			}
			else {
			$html[$start]="<a href='{$url}{$start}'>{$start}</a> ";
			}
			$start++; 
		}
		if(count($html)>=3){
			reset($html);
			$key_first=key($html);
			end($html);
			$key_end=key($html);
			if($key_first!=1){
				array_shift($html);
				array_unshift($html, "<a href='{$url}1'>1...</a>");
			}
			if($key_end!=$page_all){
				array_pop($html);
				array_push($html,"<a href='{$url}{$page_all}'>...{$page_all}</a>");
			}
		}
		var_dump($html);
	}
	if($_GET[$page]!=1){
		$prev = $_GET[$page]-1;
		array_unshift($html, "<a href='{$url}{$prev}'>上一页</a>");
	}
	if($_GET[$page]!=$page_all){
		$next = $_GET[$page]+1; //前面减了1  所以要加上2
		array_push($html,"<a href='{$url}{$next}'>下一页</a>");
	}
	$html = implode("&nbsp&nbsp&nbsp", $html);
	$data=array(
		'limit'=>$limit,
		'html'=>$html
	);
	return $data;
}
$page=page(100,10,7);
echo $page['html'];
?>

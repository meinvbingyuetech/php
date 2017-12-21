<?php
	$now =time();
	$d = floor($now-$newBlog->dateline);
	 if($d < 60){
		echo "刚刚";
	 }else if($d >=60 && $d < 3600){
		echo floor($d/60) . "分钟前";
	 }else{
		if(date('Y-m-d',$newBlog->dateline) == date('Y-m-d',$now)){
			echo  '今天 ' . date('H:i',$newBlog->dateline);
		}else{
			echo date('Y-m-d H:i',$newBlog->dateline);
		}
	 }

?>
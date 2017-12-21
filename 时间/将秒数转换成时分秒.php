<?php
//将秒数转换成时分秒
function changeTimeType($seconds){
	if ($seconds>3600){
		$hours = intval($seconds/3600);
		$minutes = $seconds600;
		$time = $hours."小时".gmstrftime('%M分%S秒', $minutes);
	}else{
		$time = gmstrftime('%M分%S秒', $seconds);
	}
	return $time;
}

function time2second($seconds){
	$seconds = (int)$seconds;
	if( $seconds>3600 ){
		if( $seconds>24*3600 ){
			$days		= (int)($seconds/86400);
			$days_num	= $days."天";
			$seconds	= $seconds%86400;//取余
		}
		$hours = intval($seconds/3600);
		$minutes = $seconds%3600;//取余下秒数
		$time = $days_num.$hours."小时".gmstrftime('%M分钟%S秒', $minutes);
	}else{
		$time = gmstrftime('%H小时%M分钟%S秒', $seconds);
	}
	return $time;
}
echo "新浪微博授权有效期剩余: ". time2second($expires) . '<hr>';
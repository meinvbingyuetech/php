<?php
/**
* jsonp或者json返回数据，优先jsonp
*/
function jsonp_json_callback($arr){
	
	if(isset($_REQUEST['test'])){
		print_r($arr);exit;
	}

	if(isset($_REQUEST['jsoncallback'])){
		die($_REQUEST['jsoncallback'].'('.json_encode($arr).')');
	}

	die(json_encode($arr));
}

/**
 * 检测是否为json string
 */
function isJSON($data)
{
	return (@json_decode($data) !== null);
}
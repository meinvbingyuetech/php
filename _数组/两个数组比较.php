<?php
/*
给定一个字符串，里面包含一组商品ID，
判断字符串里是否包含有符合套餐的ID集合，如果有，则记录起来符合套餐的数组
*/
$arr = check_taocan(array('goods_id'=>'149,287,312,316,355,356,368'));
print_r($arr);

function check_taocan($param){

	$goods_id = $param['goods_id'];
	$arr_goods_id = explode(',',$goods_id);
	
	$cfg_taocan = array(
		array(295,316,355,791,814),
		array(87,316,355,792,814),

		array(134,316,444),
		array(133,316,444),
		array(316,321,445),
		array(316,333,445),

		array(89,316,355,792,814),
		array(100,316,355,368,372),
		array(149,287,312,316,355,356,368),

		array(142,316,791),
		array(100,285,791),
		array(149,153,316,372),
		array(316,815)
	);

	$has_taocan = array();//用于记录符合套餐的数组
	foreach($cfg_taocan as $k=>$v){

		$num = 0;
		foreach($v as $item){
			if(in_array($item,$arr_goods_id)){
				$num++;
			}
		}
		
		if(count($v)==$num){
			$has_taocan[] = $v;
		}
		
	}

	return $has_taocan;
}
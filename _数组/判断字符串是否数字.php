<?php

// 支持单个数字和以逗号相连的id集合
id_is_num('26');
id_is_num('26a');
id_is_num('26,');
id_is_num('26a,27');

function id_is_num($str){
    
	if(empty($str)){
		return false;
	}

	if(strstr($str,',')){
		$arr = explode(",", $str);
		foreach ($arr as $v){
            if(!is_numeric($v)){
                return false;
            }
        }
	}
    
    if(!strstr($str,',') && !is_numeric($str)){
		return false;
	}

	return true;
}
<?php

/*
多维数组判断是否含有某值
*/
function deep_in_array($value, $array) {   
    foreach($array as $item) {   
        if(!is_array($item)) {   
            if ($item == $value) {  
                return true;  
            } else {  
                continue;   
            }  
        }   
           
        if(in_array($value, $item)) {  
            return true;      
        } else if(deep_in_array($value, $item)) {  
            return true;      
        }  
    }   
    return false;   
}

$arr = array(
	'a'=>1,
	'b'=>2,
	'c'=>array(
		'd'=>3
	)
);

if(deep_in_array('3', $arr)){
	echo 'in arr';
}
else{
	echo 'not in arr';
}
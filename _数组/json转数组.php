<?php

//简单实现json到php数组转换功能
private function simple_json_parser($json){
	$json = str_replace("{","",str_replace("}","", $json));
	$jsonValue = explode(",", $json);
	$arr = array();
	foreach($jsonValue as $v){
		$jValue = explode(":", $v);
		$arr[str_replace('"',"", $jValue[0])] = (str_replace('"', "", $jValue[1]));
	}
	return $arr;
}
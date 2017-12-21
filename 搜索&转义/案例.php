<?php

/**
 *  过滤用于搜索的字符串
 *
 * @param     string  $keyword  关键词
 * @return    string
 */
function FilterSearch($keyword)
{
	global $cfg_soft_lang;
	if($cfg_soft_lang=='utf-8')
	{
		$keyword = preg_replace("/[\"\r\n\t\$\\><']/", '', $keyword);
		if($keyword != stripslashes($keyword))
		{
			return '';
		}
		else
		{
			return $keyword;
		}
	}
	else
	{
		$restr = '';
		for($i=0;isset($keyword[$i]);$i++)
		{
			if(ord($keyword[$i]) > 0x80)
			{
				if(isset($keyword[$i+1]) && ord($keyword[$i+1]) > 0x40)
				{
					$restr .= $keyword[$i].$keyword[$i+1];
					$i++;
				}
				else
				{
					$restr .= ' ';
				}
			}
			else
			{
				if(preg_match("/[^0-9a-z@#\.]/",$keyword[$i]))
				{
					$restr .= ' ';
				}
				else
				{
					$restr .= $keyword[$i];
				}
			}
		}
	}
	return $restr;
}

/**
 * 获取预处理后的关键词数据
 * @param keyword 关键词---这里必须是转义过的搜索词
 * @param html_char 是否将关键词字符转换为 HTML 实体

 e.g: $keyword = get_preprocess_keyword(array('keyword'=>$_REQUEST['keyword'],'html_char'=>'yes'));
 */
function get_preprocess_keyword($param){

	$keywords_slash = $param['keyword'];//转义过的搜索词
	$keywords_show_web = stripslashes($keywords_slash);//页面显示用的
	$keywords_show_url = rawurlencode($keywords_show_web);//链接显示用的
	$keywords_db = array();//数据库操作用的

	$_keyword = preg_replace("/[\n| ]{2,}/", " ", $keywords_slash);//将多余的空格都整理为一个空格

	//查看该关键词是否有匹配的自定义模糊词组
	$_similar_keyword = strtolower($_keyword);//转为小写
	$arr = array(
		array('333'),
		array('line6','Line6','line 6','Line 6','LINE 6'),
		array('livid','Livid'),
		array('midiplus','Midiplus'),
		array('audient','Audient'),
		array('samson','Samson'),
		array('arturia','Arturia'),
		array('guitar wing','guitarwing','Guitar Wing'),
		array('sonicport','sonic port'),
	);
	foreach($arr as $v){
		if(in_array($_similar_keyword,$v)){
			$keywords_db = $v;
			break;
		}
	}
	
	//如果没有匹配的自定义模糊词组，则返回处理后的关键词
	if(count($keywords_db)==0){

		$_arr = array_filter(array_unique(explode(chr(32),$_keyword)));//移除重复、空值元素
		foreach($_arr as $v){
			if(isset($param['html_char'])){
				$keywords_db[] = htmlspecialchars($v);
			}
			else{
				$keywords_db[] = $v;
			}
		}

		//如果有空格，则再添加一个没有空格的搜索词
		if(preg_match("/\s/",$_keyword)){
			$keywords_db[] = preg_replace("/\s/", "", $keywords_slash);
		}
	}

	return array(
		"keywords_slash"=>$keywords_slash,
		"keywords_show_web"=>$keywords_show_web,
		"keywords_show_url"=>$keywords_show_url,
		"keywords_db"=>$keywords_db,
	);
}
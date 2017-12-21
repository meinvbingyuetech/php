<?php
//清空cookie值
SetCookie("tl_cookie_music","", time()-1/time());

//设置二维cookie值
setcookie('ECS[visit_times]', $visit_times, $time + 86400 * 365, '/');

//获取二维cookie值
$visit_times = (!empty($_COOKIE['ECS']['visit_times'])) ? intval($_COOKIE['ECS']['visit_times']) + 1 : 1;

$cookie_time = time() + 3600 * 24 * 180;// 时间为 180 天
setcookie("MG[member_province_id]",$province_id,$cookie_time,'/');
$province_id = $_COOKIE['MG']['member_province_id'];

/**
 * 设置cookie
 */
function addCookie($key,$value,$kptime=0,$pa="/")
{
	global $cfg_cookie_encode;
	setcookie($key,$value,time()+$kptime,$pa);
	setcookie($key.'__ckMd5',substr(md5($cfg_cookie_encode.$value),0,16),time()+$kptime,$pa);
}

/**
 * 删除cookie
 */
function delCookie($key)
{
	setcookie($key,'',time()-360000,"/");
	setcookie($key.'__ckMd5','',time()-360000,"/");
}

/**
 * 获取cookie
 */
function getCookie($key)
{
	global $cfg_cookie_encode;
	if( !isset($_COOKIE[$key]) || !isset($_COOKIE[$key.'__ckMd5']) )
	{
		return '';
	}
	else
	{
		if($_COOKIE[$key.'__ckMd5']!=substr(md5($cfg_cookie_encode.$_COOKIE[$key]),0,16))
		{
			return '';
		}
		else
		{
			return $_COOKIE[$key];
		}
	}
}
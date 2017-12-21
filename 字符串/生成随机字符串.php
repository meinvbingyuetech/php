<?php

/**
  +----------------------------------------------------------
 * 生成随机字符串
  +----------------------------------------------------------
 * @param int       $length  要生成的随机字符串长度
 * @param string    $type    随机码类型：0，数字+大小写字母；1，数字；2，小写字母；3，大写字母；4，特殊字符；-1，数字+大小写字母+特殊字符
  +----------------------------------------------------------
 * @return string

   echo randCode(10,0);
  +----------------------------------------------------------
 */
 function randCode($length = 5, $type = 0) {
    $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
    if ($type == 0) {
        array_pop($arr);
        $string = implode("", $arr);
    } elseif ($type == "-1") {
        $string = implode("", $arr);
    } else {
        $string = $arr[$type];
    }
    $count = strlen($string) - 1;
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $string[rand(0, $count)];
    }
    return $code;
 }


/**
 * 获取随机字符
 */
function getRandomString($length = 10)
{
	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	return substr(str_shuffle(str_repeat($pool, ceil($length / strlen($pool)))), 0, $length);
}

/**
 * 返回随机码
 */
function _getRandomString($length = 10)
{
	$salt1 = substr(uniqid(rand()), -6);
	$salt2 = substr(uniqid(rand()), -6);
	return $salt2 . $salt1;
}

/**
 * 生成随机的数字串
 *
 * @author: weber liu
 * @return string
 */
function random_filename()
{
	$str = '';
	for($i = 0; $i < 9; $i++)
	{
		$str .= mt_rand(0, 9);
	}

	return gmtime() . $str;
}
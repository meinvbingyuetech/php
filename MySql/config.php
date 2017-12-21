<?php
set_time_limit(0);
header('Content-Type:text/html;charset=gb2312');
date_default_timezone_set('Asia/Shanghai');
ini_set("display_errors","Off");
//ini_set("mssql.datetimeconvert","0");

/**
 * 数据库配置
 */
$hostname = "222.122.118.101"; //主机名
$username = "meinvbingyue"; //用户名
$password = "wang7862102"; //密码
$dataname = "houtai"; //数据库名
$code = "gb2312"; //编码 latin1

/**
 *连接数据库
 */
$conn = FALSE;
$conn = mysql_connect($hostname,$username,$password,TRUE);
mysql_select_db($dataname,$conn);
mysql_query("SET NAMES $code;");
mysql_query("SET character_set_connection=$code, character_set_results=$code;");

if (!$conn){
	die('Could not connect: ' . mysql_error());
}

mysql_close($conn);
?>
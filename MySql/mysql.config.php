<?php
header('Content-Type:text/html;charset=gbk');
date_default_timezone_set('Asia/Shanghai');
set_time_limit(0);

/**
 * 数据库配置
 */
$hostname = "localhost"; //主机名
$username = "root"; //用户名
$password = "jason20051"; //密码
$dataname = "test"; //数据库名
$code = "gbk"; //编码

/**
 *连接数据库
 */
$conn = FALSE;
$conn = mysql_connect($hostname,$username,$password,TRUE);
mysql_select_db($dataname,$conn);
mysql_query("SET NAMES $code;");
mysql_query("SET character_set_connection=$code, character_set_results=$code;");

if($conn==FALSE){
	die("数据库连接失败！!");
}

//echo $conn;
?>

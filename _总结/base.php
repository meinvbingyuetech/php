<?php
exit;
set_time_limit(0);
ini_set("display_errors", "Off");

//获取http头信息
$arr = get_headers($url);

//下载
echo "<script language='javascript'>location=\"$link\";</script>";

/*********************************************************************************
 * Header 函数
 */
header('Content-Type:text/html;charset=gb2312');

//此代码放于页面输出前，先查找客户端缓存文件，只有客户端缓存文件不存在、过期、用户F5刷新才从服务器读取页面，可以有效减少服务器压力，但是对于需要时时更新的页面不适用，如论坛、投票等程序
header('Cache-Control:max-age=86400, must-revalidate');//24小时
header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
header('Expires:'.gmdate('D, d M Y H:i:s', time() + '86400').'GMT');

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

header("Cache-Control: no-store, no-cache, must-revalidate");

Header( "HTTP/1.1 301 Moved Permanently" );
Header( "Location: http://www.kan3.com" );

header('Content-Type:application/json;charset=utf-8'); //输出JSON格式


/*********************************************************************************
* 二元判断
*/
$mtypesid = isset ($mtypesid) && is_numeric($mtypesid) ? $mtypesid : 0;
$aid = isset ($aid) && is_numeric($aid) ? $aid : 0;
$money = is_array($row) ? $row['money'] : 0;
$ischeck = ($cfg_mb_msgischeck == 'Y') ? 0 : 1;

/*********************************************************************************
 * 常用函数
 */
intval();
is_numeric();// 判断是否为数字
is_null();
strip_tags(string,allow);//剥去 HTML、XML 以及 PHP 的标签（该函数始终会剥离 HTML 注释。这点无法通过 allow 参数改变。）
strpos();//获取字符串下标
str_replace();
strtolower();
strlen();
substr();
nl2br(); //在字符串中的每个新行 (\n) 之前插入 HTML 换行符 (<br/>)


?>
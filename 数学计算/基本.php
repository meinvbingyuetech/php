<?php
//保留两位数
$num = 123213.666666;  
echo sprintf("%.2f", $num); //123213.67
echo number_format($num, 2, '.', ''); //效果一样

//四舍五入保留两位数
$number = 1234.5678;
echo round($number ,2); //1234.57
// 先四舍五入，不保留小数
$price = round($price);

// 保留不为 0 的尾数
$price = preg_replace('/(.*)(\\.)([0-9]*?)0+$/', '\1\2\3', number_format($price, 2, '.', ''));
if (substr($price, -1) == '.')
{
	$price = substr($price, 0, -1);
}
// 不四舍五入，保留1位
$price = substr(number_format($price, 2, '.', ''), 0, -1);
// 直接取整
$price = intval($price);
// 四舍五入，保留 1 位
$price = number_format($price, 1, '.', '');

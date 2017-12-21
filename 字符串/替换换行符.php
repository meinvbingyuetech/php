<?php 

//php 有三种方法来解决 
  
//1、使用str_replace 来替换换行 
$str = str_replace(array("\r\n", "\r", "\n"), "", $str); 
  
//2、使用正则替换 
$str = preg_replace('//s*/', '', $str); 
  
//3、使用php定义好的变量 （建议使用） 
$str = str_replace(PHP_EOL, '', $str);
复制代码
复制代码
// 转为前台可显示的换行， nl2br 的方向函数参考php手册
$str = "a
b
e
f
c";

echo nl2br($str);

 ?>
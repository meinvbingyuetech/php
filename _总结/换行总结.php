\n -> newline
\r -> return
\t -> tab

<?php 
/*
第一种写法: 
$content=str_replace("\n","",$content); 
echo $content; 

第二种写法: 
str_replace("\r\n","",$str); 

第三种写法: 
$content=preg_replace("/\s/","",$content); 
echo $content; 

附: 

首先说说\n,\r,\t 
\n 软回车： 
在Windows 中表示换行且回到下一行的最开始位置 
在Linux、unix 中只表示换行，但不会回到下一行的开始位置。 
\r 软空格： 
在Linux、unix 中表示返回到当行的最开始位置。 
在Mac OS 中表示换行且返回到下一行的最开始位置，相当于Windows 里的 \n 的效果。 
\t 跳格（移至下一列）
几点说明：
它们在双引号或定界符表示的字符串中有效，在单引号表示的字符串中无效。
\r\n 一般一起用，用来表示键盘上的回车键(Linux,Unix中)，也可只用 \n(Windwos中)，在Mac OS中用\r表示回车！
\t表示键盘上的“TAB”键。
文件中的换行符号：
windows : \n
linux,unix: \r\n
*/


//php 不同系统的换行 
//不同系统之间换行的实现是不一样的 
//linux 与unix中用 /n 
//MAC 用 /r 
//window 为了体现与linux不同 则是 /r/n 
//所以在不同平台上 实现方法就不一样 
//php 有三种方法来解决 

//1、使用str_replace 来替换换行 
$str = str_replace(array("/r/n", "/r", "/n"), "", $str); 

//2、使用正则替换 
$str = preg_replace('//s*/', '', $str); 

//3、使用php定义好的变量 （建议使用） 
$str = str_replace(PHP_EOL, '', $str); 
?>
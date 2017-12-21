<?php

//每隔1秒刷新一下输出
echo date("H:m:s"), "<br>";
set_time_limit(100);
//ob_start(); //要把这去掉才会 每隔1秒刷新一下输出
for ($i = 0; $i < 10; $i++)
{
	sleep(1);
	echo date("H:m:s"),"<br>";
	ob_flush();
	flush();
}

echo "Done!";
ob_end_flush();

echo "<hr>";
?>

<?php
ob_end_clean();
for ($i=10; $i>0; $i--)
{
	echo $i."<br>";
	flush();
	sleep(1);
}

echo "<hr>";
?>

<?php

ob_end_clean();
ob_implicit_flush(true);

echo str_repeat(' ', 1024);//为了填满浏览器的缓冲区，有些浏览器要达到一定的缓存才开始显示数据

for ($i=10; $i>0; $i--){
echo $i."<br>";
sleep(1);
}
?>
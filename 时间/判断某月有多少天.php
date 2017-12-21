用php内置的函数shortime()获取该月和下月1号的时间戳，再计算即可

如想知道 1982年7月的天数，
<?php 
$t= (strtotime("1 july 1982")-strtotime("1 june 1982"));
$days=$t/(60*60*24);
echo $days;
?>
//输出：30
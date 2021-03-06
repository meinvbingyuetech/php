<?php
$fdate_time_array = getdate();//数组
$fyear = $fdate_time_array["year"];  //年
$fmon = $fdate_time_array["mon"];  //月
$fmday = $fdate_time_array["mday"]; //日
$fhours = $fdate_time_array["hours"];  //时
$fminutes = $fdate_time_array["minutes"];//分
$fseconds = $fdate_time_array["seconds"];//秒
$fwday = $fdate_time_array["wday"];   //星期(数字)
$fweekday = $fdate_time_array["weekday"];//星期(英文)
$fmonth = $fdate_time_array["month"];  //月份(英文)
$fyday = $fdate_time_array["yday"];  //一年中的第几日
$ftime = $fdate_time_array[0];  //时间戳

echo date('Ymd', strtotime('-30 days')).'000000'; // 最近30天

echo date("Y/m/d 0:0:0", strtotime("1 days ago")); //昨天开始
echo "<br>";
echo date("Y/m/d 23:59:59", strtotime("1 days ago")); //昨天结束
echo "<hr>";
echo date("Y/m/d 0:0:0", strtotime("2 days ago")); //前天开始
echo "<br>";
echo date("Y/m/d 23:59:59", strtotime("2 days ago")); //前天结束


//将时间戳转化为时分秒显示格式
gmstrftime('%H:%M:%S',800);

strftime("%Y-%m-%d %H:%I:%S",time())


//当天的时间区间
$begin = strtotime(date("Y-m-d",time()));
$end = $begin+86400-1;

echo $ctime = strtotime(date("Y-m-d",time()))-1;
echo "<hr>";

//昨天
echo $yestoday_end = date("Y-m-d H:i:s",$ctime);
echo "<br>";
echo $yestoday_start = date("Y-m-d H:i:s",($ctime-86399));
echo "<hr>";

//最近七天
echo $week_start = date("Y-m-d H:i:s",($ctime-(86400*7)+1));
echo "<br>";
echo $week_end = $yestoday_end;

echo "<hr>";

echo date("Ymd",strtotime("now")), "\n";
echo date("Ymd",strtotime("-1 week Monday")), "\n";
echo date("Ymd",strtotime("-1 week Sunday")), "\n";
echo date("Ymd",strtotime("+0 week Monday")), "\n";
echo date("Ymd",strtotime("+0 week Sunday")), "\n";

//获取星期几
$weekarray=array("日","一","二","三","四","五","六");
echo "星期".$weekarray[date("w")];

//date('n') 第几个月
//date("w") 本周周几
//date("t") 本月天数

echo '<br>上周:<br>';
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"))),"\n";
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"))),"\n";
echo '<br>本周:<br>';
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"))),"\n";
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))),"\n";

echo '<br>上月:<br>';
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y"))),"\n";
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y"))),"\n";
echo '<br>本月:<br>';
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y"))),"\n";
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y"))),"\n";

$getMonthDays = date("t",mktime(0, 0 , 0,date('n')+(date('n')-1)%3,1,date("Y")));//本季度未最后一月天数
echo '<br>本季度:<br>';
echo date('Y-m-d H:i:s', mktime(0, 0, 0,date('n')-(date('n')-1)%3,1,date('Y'))),"\n";
echo date('Y-m-d H:i:s', mktime(23,59,59,date('n')+(date('n')-1)%3,$getMonthDays,date('Y'))),"\n";
?>

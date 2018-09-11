```php
// 获取昨天的年月日
$yesterday = Carbon::yesterday()->toDateString();  // 2018-08-14


Carbon::now()                   //2018-08-15 10:02:01
Carbon::now()->format('Y-m-d')

Carbon::now()->addMinutes(3)

// 格式化
Carbon::parse($item->record_at)->format('Y/m/d H:i');
Carbon::parse('2018-01-12 02:36:16')->format("YmdHis");

// 今天
Carbon::today()->format("Y-m-d H:i:s")    // 2018-08-15 00:00:00

// 下个月
$start_year_month = Carbon::now()->addMonth(1)->format('Y-m');
$end_year_month = Carbon::now()->addMonth(1)->format('Y-m');

// 判断当前时间是否大于早上9点
$nine = Carbon::create(date('Y', time()),date('m', time()),date('d', time()),9,0,0);
Carbon::now()->gte($nine)

//时间戳
Carbon::parse('2018-05-09')->timestamp    // 1525795200

Carbon::create(2018, 8, 8)      //2018-08-08 10:10:24

/************************************************************************/
list($year1, $month1, $day1) = explode('-', date('Y-m-d', $begin_time));
list($year2, $month2, $day2) = explode('-', date('Y-m-d', $end_time));

$result = Carbon::create($year2, $month2, $day2)->diff(Carbon::create($year1, $month1, $day1));
'year' => $result->y,
'month' => $result->m,
'day' => $result->d,

/************************************************************************/
//1、基本应用
$now = Carbon::now();                    //2016-11-03 14:13:16
$today = Carbon::today();                //2016-11-03 00:00:00
$tomorrow = Carbon::tomorrow();          //2016-11-04 00:00:00
$yesterday = Carbon::yesterday();        //2016-11-02 00:00:00

//2、判断是否是某一天(2016-11-03（周四）举例)
$now = Carbon::now();
var_dump($now->isWeekend());//false 因为周四不是周末
var_dump($now->isWeekday());//true  因为周四是工作日
var_dump($now->isThursday());//true 因为今天是周四
$now->isToday();
$now->isTomorrow();
$now->isFuture();
$now->isPast();

//3、创建某一天的carbon对象并且进行加减计算
$date = Carbon::create(2016, 12, 25, 0, 0, 0);//2016-12-25 00:00:00
$next_year=$date->addYears(2);//2018-12-25 00:00:00
$past_year=$date->subYears(2);//2014-12-25 00:00:00
$next_month=$date->addMonths(2);//2017-02-25 00:00:00
$past_month=$date->subMonths(2);//2016-10-25 00:00:00
$next_day=$date->addDays(2);//2016-12-27 00:00:00
$past_day=$date->subDays(2);//2016-12-23 00:00:00
...更有addWeekdays()、addWeeks()、addHours()等方法

//4、将carbon对象转换成string类型
$dt = Carbon::create(1975, 12, 25, 14, 15, 16);
echo $dt->toDateString();                          // 1975-12-25
echo $dt->toFormattedDateString();                 // Dec 25, 1975
echo $dt->toTimeString();                          // 14:15:16
echo $dt->toDateTimeString();                      // 1975-12-25 14:15:16
echo $dt->toDayDateTimeString();                   // Thu, Dec 25, 1975 2:15 PM

```

```php
//获取当前时间

echo Carbon::now().'<br />';

//获取当前时间的固定格式

echo Carbon::now()->format('Y-m-d').'<br />';

//获取当前时间的时间戳

echo Carbon::now()->timestamp.'<br />';

//设置当前地区的时区

echo Carbon::now()->timezone('Asia/Shanghai').'<br />';

//获取特定时间的时间戳

echo '昨天的当前时间时间戳:'.Carbon::now()->subDay(1)->timestamp.'<br />';

//获取前一天的开始与结束时间

echo '前一天开始时间:'.Carbon::now()->yesterday()->startOfDay()->timezone('Asia/Shanghai')->format('Y-m-d H:i:s').'<br />';

echo '前一天结束时间:'.Carbon::now()->yesterday()->endOfDay()->timezone('Asia/Shanghai').'<br />';



//获取上一周的开始与结束时间

echo '上一周开始时间:'.Carbon::now()->previous()->startOfWeek()->timezone('Asia/Shanghai')->format('Y-m-d H:i:s').'<br />';

echo '上一周结束时间:'.Carbon::now()->previous()->endOfWeek()->timezone('Asia/Shanghai').'<br />';



//获取上一月的开始与结束时间

echo '上一月开始时间:'.Carbon::now()->subMonth(1)->startOfMonth()->timezone('Asia/Shanghai')->format('Y-m-d H:i:s').'<br />';

echo '上一月结束时间:'.Carbon::now()->subMonth(1)->endOfMonth()->timezone('Asia/Shanghai').'<br />';



//获取上一年的开始与结束时间

echo '上一年开始时间:'.Carbon::now()->subYear(1)->startOfYear()->timezone('Asia/Shanghai')->format('Y-m-d H:i:s').'<br />';

echo '上一年结束时间:'.Carbon::now()->subYear(1)->endOfYear()->timezone('Asia/Shanghai').'<br />';

//获取今年的开始与结束时间

echo '今年开始时间:'.Carbon::now()->lastOfYear()->startOfYear()->timezone('Asia/Shanghai')->format('Y-m-d H:i:s').'<br />';

echo '今年结束时间:'.Carbon::now()->lastOfYear()->endOfYear()->timezone('Asia/Shanghai').'<br />';
```


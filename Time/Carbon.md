```php

// 判断当前时间是否大于早上9点
$nine = Carbon::create(date('Y', time()),date('m', time()),date('d', time()),9,0,0);
Carbon::now()->gte($nine)

// 格式化
Carbon::parse($item->record_at)->format('Y/m/d H:i');

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
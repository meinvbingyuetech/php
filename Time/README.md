```php

/**
 * 将某个时间转为 该时间对应的 天、周、月
 *
 * @param $type
 * @param $time 只接受时间戳
 */
public function convertTimeToDayWeekMonth($type, $time)
{
    $str = '';

    if (strlen($time)!=10){
        $time = strtotime($time);
    }

    if ($type=='day'){
        $str = date('Ymd',$time);
    } else if ($type=='week'){
        $str = date('oW', $time);
    } else if ($type=='month'){
        $str = date('Ym', $time);
    }

    return $str;
}
    
```

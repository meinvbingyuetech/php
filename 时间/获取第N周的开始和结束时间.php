<?php

$weeks = get_week(2011); 
echo '第18周开始日期：'.$weeks[18][0].''; 
echo '第18周结束日期：'.$weeks[18][1];

/**
 * 获取某年的每周第一天和最后一天
 * @param  [int] $year [年份]
 * @return [arr]       [每周的周一和周日]
 */
function get_week($year) {
    $year_start = $year . "-01-01";
    $year_end = $year . "-12-31";
    $startday = strtotime($year_start);
    if (intval(date('N', $startday)) != '1') {
        $startday = strtotime("next monday", strtotime($year_start)); //获取年第一周的日期
    }
    $year_mondy = date("Y-m-d", $startday); //获取年第一周的日期

    $endday = strtotime($year_end);
    if (intval(date('W', $endday)) == '7') {
        $endday = strtotime("last sunday", strtotime($year_end));
    }

    $num = intval(date('W', $endday));
    for ($i = 1; $i <= $num; $i++) {
        $j = $i -1;
        $start_date = date("Y-m-d", strtotime("$year_mondy $j week "));

        $end_day = date("Y-m-d", strtotime("$start_date +6 day"));

        $week_array[$i] = array (
            str_replace("-",
            ".",
            $start_date
        ), str_replace("-", ".", $end_day));
    }
    return $week_array;
}
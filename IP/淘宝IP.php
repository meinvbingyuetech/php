<?php

$_json_tbip = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
$_arr_tbip = json_decode($_json_tbip,true);
print_r($_arr_tbip);exit;

/*

Array
(
    [code] => 0
    [data] => Array
        (
            [country] => 中国
            [country_id] => CN
            [area] => 华南
            [area_id] => 800000
            [region] => 广东省
            [region_id] => 440000
            [city] => 广州市
            [city_id] => 440100
            [county] => 
            [county_id] => -1
            [isp] => 电信
            [isp_id] => 100017
            [ip] => 14.150.212.57
        )

)


*/
?>
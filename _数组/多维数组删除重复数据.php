<?php

/**
 * 多维数组删除重复数据
 * @param $array 传入多维数组
 * @return array 返回去除重复后的数组
 */
function arrMultUnique($array)
{
    $return = array();
    foreach($array as $key=>$v)
    {
        if(!in_array($v, $return))
        {
            $return[$key]=$v;
        }
    }
    return $return;
}
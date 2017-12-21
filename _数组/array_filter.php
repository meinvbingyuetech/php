<?php 

// 过滤为空的参数
$filter_func = function ($val) {
    return '' !== $val;
};
$condition = array_filter($condition, $filter_func);
        
?>
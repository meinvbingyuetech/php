<?php 

## 加括号
$str = preg_replace('/<center>(.*?)<\/center>/iU', '<p align="center">${1}</p>', $str);//把所有center标签替换成


## 不加括号
$str = preg_replace([
    '/<[a-z]><\/[a-z]>/i', // 删除空标签
    '/<div class="abstract">.*?<\/div>/iU',
    '/<img.*正文底部二维码0522\.png.*>/iU',
], '', $str);

?>
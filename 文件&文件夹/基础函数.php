<?php 

echo  __FILE__;
        echo '<BR>';
        echo __DIR__;
        echo '<BR>';
        print_r(pathinfo(__FILE__)); //返回文件路径的信息
        echo '<BR>';
        echo dirname(__FILE__); //返回路径中的目录部分
        echo '<BR>';
        echo basename(__FILE__); //返回路径中的文件名部分
        echo '<BR>';
        echo realpath(__FILE__); //返回规范化的绝对路径名
        echo '<BR>';
        exit;

 ?>
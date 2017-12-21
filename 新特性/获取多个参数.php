<?php 


test(1,2,3,4,5);

function test($var, ...$_)
{
    $arr = func_get_args();
    var_dump($arr);
}

?>
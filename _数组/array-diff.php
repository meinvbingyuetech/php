<?php 

$new = array(1,2,3);
$old = array(1,2,4);

$insert = array_diff($new, $old);#新旧不同则增
$del = array_diff($old, $new);#旧新不同则减
print_r($del);
?>
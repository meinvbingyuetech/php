<?php 

$str = '<div class="top_city fl"><div class="top_city fl user">';

$str = preg_replace_callback('/class="([^\"]*)"/isU',function ($reg){
    $reg[1] = strtr($reg[1],array(' '=>''));
    return sprintf('class="%s"',$reg[1]);
}, $str);

echo htmlspecialchars($str);

 ?>
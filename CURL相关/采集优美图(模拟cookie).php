<?php

header("Content-type:text/html;Charset=utf8");
$ch =curl_init();
curl_setopt($ch,CURLOPT_URL,'http://www.topit.me/item/38852?p=2');


curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//curl_setopt($ch,CURLOPT_HEADER,true);
curl_setopt($ch,CURLOPT_COOKIE,'is_click=1; bdshare_firstime=1451222319123;');


$content = curl_exec($ch);
echo $content;
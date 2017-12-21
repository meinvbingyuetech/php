<?php

$data = array(
	'uid'	=>	1,
	'pic'	=>	'@'.realpath('./mypic.png').';type=image/png'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/server_upload.php' );
curl_setopt($ch, CURLOPT_POST, true );
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$return_data = curl_exec($ch);
curl_close($ch);
echo $return_data;


/*
server_upload.php:

Array
(
    [uid] => 10086
)
_______________________
Array
(
    [pic] => Array
    (
       [name] => mypic.png
       [type] => image/png   //此时文件类型已被成功设置
       [tmp_name] => C:\Windows\Temp\phpF1E1.tmp
       [error] => 0
       [size] => 5903
    )
)
*/
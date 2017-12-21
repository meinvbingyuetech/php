#常见一个PHP文件，返回数组
<?php
return array(
	'key'=>'value',
);
?>


#在其他文件这样使用
<?php

$_c = include_once(dirname(__FILE__)."/config.php");
echo $_c['key'];
?>
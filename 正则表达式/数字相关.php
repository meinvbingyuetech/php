<?php
$build_url = "/category-x-20-0-b0-default-0-yy0-cj0-p1.html?jpjs=2&jpsg=0&yxcc=0";
preg_replace("/jpjs=(\d+)/i", "jpjs={$num}", $build_url);


//提取数字
preg_match_all("/\d+/",$string,$arr);


$aid = ereg_replace("[^0-9]","",$aid);
if($aid=="")
{
	exit("id不合法");
}
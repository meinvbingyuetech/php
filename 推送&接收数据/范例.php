<?php

/***********************推送数据*****************************/

$data = array('username'=>'meinvbingyue','age'=>'21','time'=>date('Y-m-d H:i:s',time()));
$postUrl = "http://app.imus.cn/common/online_status.php";
$header=array("Content-Type:application/json","Keep-Alive: 300","Connection: keep-alive");
$curlPost = json_encode($data);

$ch = curl_init();//初始化curl
curl_setopt($ch, CURLOPT_TIMEOUT, '30');//超时时间
curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; GTB7.4; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2)');
curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
$data = curl_exec($ch);//运行curl
curl_close($ch);


/***********************接收数据*****************************/

//$raw_post_data = file_get_contents('php://input', 'r');
$raw_post_data = $GLOBALS['HTTP_RAW_POST_DATA'];

echo file_put_contents(dirname(__FILE__).'/online_status/'.time().'.txt',$raw_post_data);


?>
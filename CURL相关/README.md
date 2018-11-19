```php

/*
模拟 POSTMAN -》 
POST方式
Body->raw （不是form-data）
传递的数据是json串：
{
    "display_type": 0,
    "appId": 2
}
*/
$post_data = [
	'display_type'=>0,
	'appId'=>2
];
$jsonDataEncoded = json_encode($post_data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $push_api);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
	'Content-Type: application/json'
]);
$result=curl_exec ($ch);
$result_arr = json_decode($result, true);

/*
对于传递post数据，可能会是数组，也可能会是json字符串，按需求来吧
*/

/*
$post_data = array ("com" => $typeCom,"no" => $typeNu,"muti" => 1,"ord" => "desc");
$url = "http://q.kuaidi100.cn/query.php";
$res = do_post($url, $post_data);
*/
function do_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;
}

//传递POST数据
// $data是数组/json字符串,按需求
function _curl($data,$url){
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $url);
	 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	 curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 $tmpInfo = curl_exec($ch);
	 if (curl_errno($ch)) {
	  return curl_error($ch);
	 }
	 curl_close($ch);
	 return $tmpInfo;
}

//POST方式提交数据  
function dataPost($post_string, $url) {
 $context = array ('http' => array ('method' => "POST", 'header' => "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) \r\n Accept: */*", 'content' => $post_string ) );  
 $stream_context = stream_context_create ( $context );  
 $data = file_get_contents ( $url, FALSE, $stream_context );  
 return $data;  
 }  

//调用https链接，开启SSL
function httpGet($url) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_TIMEOUT, 500);
	// 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
	// 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
	curl_setopt($curl, CURLOPT_URL, $url);

	$res = curl_exec($curl);
	curl_close($curl);

	return $res;
}

//普通请求
function _curl($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22");
	curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

/**
 * 远程获取数据，POST模式
 * 注意：
 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
 * @param $url 指定URL完整路径地址
 * @param $cacert_url 指定当前工作目录绝对路径
 * @param $para 请求的数据
 * @param $input_charset 编码格式。默认值：空值
 * return 远程输出的数据
 */
function getHttpResponsePOST($url, $cacert_url, $para, $input_charset = '') {

	if (trim($input_charset) != '') {
		$url = $url."_input_charset=".$input_charset;
	}
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
	curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
	curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
	curl_setopt($curl,CURLOPT_POST,true); // post传输数据
	curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
	$responseText = curl_exec($curl);
	//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
	curl_close($curl);
	
	return $responseText;
}

/**
 * 远程获取数据，GET模式
 * 注意：
 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
 * @param $url 指定URL完整路径地址
 * @param $cacert_url 指定当前工作目录绝对路径
 * return 远程输出的数据
 */
function getHttpResponseGET($url,$cacert_url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
	curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
	$responseText = curl_exec($curl);
	//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
	curl_close($curl);
	
	return $responseText;
}

/**
 * 使用代理服务器IP来采集
 */
$requestUrl = 'http://www.kuaidi100.com/query?type=shentong&postid=3303553442603';
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
curl_setopt($ch, CURLOPT_PROXY, "14.152.37.194"); //代理服务器地址
curl_setopt($ch, CURLOPT_PROXYPORT, 80); //代理服务器端口
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, ":"); //http代理认证帐号，username:password的格式
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //使用http代理模式
$file_contents = curl_exec($ch);
curl_close($ch);
echo $file_contents;

function _curlByIP($url,$ip){
	$c = curl_init();  
	curl_setopt($c, CURLOPT_URL, $url);  
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 60);    
	curl_setopt($c, CURLOPT_PROXY ,$ip);

	curl_setopt($c, CURLOPT_HEADER, 0);//强制输出header
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_ENCODING, 'gzip');

	$contents = curl_exec($c);
	curl_close($c);

	//$curlInfo = curl_getinfo($c);
	//print_r($curlInfo);
	//echo "<br><textarea style='width:800px;height:400px'>".$contents."</textarea>";

	$contents = preg_replace("'([\r\n])[\s]+'", "", $contents);
	
	return $contents;
}

function _curl_proxy($url){
    $requestUrl = $url;
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $requestUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
    curl_setopt($ch, CURLOPT_PROXY, "58.96.187.234"); //代理服务器地址
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128); //代理服务器端口
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, ":"); //http代理认证帐号，username:password的格式
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //使用http代理模式
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}

function _curlImg($url){
	$arr_headers = array('Accept: */*',
				'Accept-Language: zh-CN',
				'Accept-Encoding: gzip, deflate',
				'User-Agent: ' . 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; BOIE9;ZHCN)',
				'Connection: Keep-Alive',
				'Cache-Control: no-cache',
				);
	$c = curl_init();  
	curl_setopt($c, CURLOPT_URL, $url);  
	curl_setopt($c, CURLOPT_GET, true);
	//curl_setopt($c, CURLOPT_HEADER,1);//强制输出header
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($c, CURLOPT_TIMEOUT, 1200); 
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);//抓取重定向的文件
	curl_setopt($c, CURLOPT_HTTPHEADER, $arr_headers);//送出header

	$contents = curl_exec($c);
	curl_close($c);
	return $contents;
}

function _curlImgToFile($picUrl,$picPath){

	$imageData = _curlImg($picUrl);
 
	$tp = @fopen($picPath, 'wb');
	$filesize = fwrite($tp, $imageData);
	fclose($tp);

	return $filesize;
}

/**********************************************************************************************/

$url =  'http://apis.baidu.com/baidu_communication/baidusms/baidusms?profileCode=pjN4ZsJR-8YCm-v06K-h3KH&phoneNumber=15652199548&templateCode=smsTpl:eebb8652-deec-495c-a70c-558e46b20b8b';

$contentVar = array(
        'node' => '123456',
        'param' => '123456123456123456123456123456'
);


$contentVar = json_encode($contentVar);  //必须是json串
$contentVar = urlencode($contentVar);   //必须经过urlencode编码

$url .= '&contentVar='.$contentVar;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('apikey: 您的apikey'));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
if (curl_errno($ch))
{
throw new Exception('请求apistore失败!', self::CURL_ERROR);
}

curl_close($ch);
var_dump($response);
```

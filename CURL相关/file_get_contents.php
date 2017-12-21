<?php

function get_url_contents($url)
{
    if (ini_get("allow_url_fopen") == "1")
        return file_get_contents($url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result =  curl_exec($ch);
    curl_close($ch);

    return $result;
}

/**
 * 用于fopen(),file_get_contents()等过程的超时设置、代理服务器、请求方式、头信息设置的特殊过程。
 */

$opts = array (
	'http' => array (
		'method' => "GET",
		'timeout' => 60,
//		'proxy' => 'tcp://127.0.0.1:8080',
//		'request_fulluri' => true,
//		'header'=>"Accept-language: en\r\n Cookie: foo=bar\r\n",
//		'header'=>"Content-Type: text/xml; charset=utf-8",
	)
);
//创建数据流上下文
$context = stream_context_create($opts);

echo $html = file_get_contents('http://www.baidu.com', false, $context);

/********************************************************/
/**
 * 失败时重试几次，仍然失败就放弃
 */
/*
$cnt = 0;
while ($cnt < 3 && ($str = @ file_get_contents('http://blog.sina.com/mirze')) === FALSE)
	$cnt++;

echo $str;
*/

/********************************************************/
/*
function Post($url, $post = null) {
	$context = array ();

	if (is_array($post)) {
		ksort($post);

		$context['http'] = array (
			'timeout' => 60,
			'method' => 'POST',
			'content' => http_build_query($post,
			'',
			'&'
		),);
	}
	return file_get_contents($url, false, stream_context_create($context));
}

$data = array (
	'name' => 'test',
	'email' => 'test@gmail.com',
	'submit' => 'submit',

);
echo Post('http://www.ej38.com', $data);
*/
?>
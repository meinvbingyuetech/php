<?php
// --> PHP_EOL 
/*
* 常用
*/

if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
  $nameErr = "只允许字母和空格"; 
}
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
  $emailErr = "非法邮箱格式"; 
}
if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
  $websiteErr = "非法的 URL 的地址"; 
}

$cardid = eregi_replace("[^a-z0-9-]", "", $cardid);
$cardid = eregi_replace("[^A-Z0-9-]", "", $cardid);

$cardid = ereg_replace("[^0-9A-Za-z-]", "", $cardid);
if (empty ($cardid)) {
	exit ("卡号为空！");
}

$softurl = stripslashes($softurl);
if (!preg_match("#[_=&///?\.a-zA-Z0-9-]+$#i", $softurl)) {
	exit ("确定软件地址提交正确！");
}

////////////////判断用
if (!preg_match("/([a-zA-Z0-9\-\.\_])+$/", $url)) {
	return false;
}


/**
 * 给入一个字符串，获取所有A标签里面的链接和文字
 * e.g: $ss = match_alink($contents); print_r($ss);
 */
function match_alink($document) {
	preg_match_all("'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1)(.*?)\\1|([^\s\>]+))[^>]*>?(.*?)</([^>]*)>'isx", $document, $links);

	for ($i = 0; $i < count($links[2]); $i++) {
		$match[$i] = array (
			'link' => $links[2][$i],
			'content' => $links[4][$i]
		);
	}
	return $match;
}


//http://www.imus.cn:8114/xinwen/p1.html	http://www.imus.cn:8114/xinwen/hot_p1.html
$sort_url = preg_replace('/(hot|comt)_p(.*?).html/i',"",$pc_url);
$sort_url = preg_replace('//p[0-9].html/i',"",$pc_url);

$contents = file_get_contents($_POST['caiji_url']);
$contents = preg_replace("'([\r\n])[\s]+'", "", $contents);
preg_match_all("/<div>(.*?)<\/div>/isU", $contents, $m);

//分割换行的数据
$arr = explode("\n",$content);
       explode('\r\n',$content)

$lianxi = str_replace(chr(13),"<br>",$_POST[lianxi]);
$lianxi = str_replace(chr(32)," ",$lianxi);

$reg = array("\r\n", "\n", "\r"); 
$replace = array("<br>","<br>"," "); 
$shopdesc = str_replace($reg, $replace, $shopdesc); 

/////  $(this).val().replace(/<[^>]+>/ig,'')   js用的，不知道PHP能不能用到，先记录起来
$link = preg_replace('/http:\/\/www.youku.com\/v_show\/id_(.*)_rss.html/',"http://player.youku.com/player.php/sid/$1/v.swf",$link);

$id = ereg_replace("[^0-9]","",$id);if($id==""){exit;}

//将2换为8
preg_replace('/(page=)(\d+)/is', "\${1}8", "?page=2");

//替换index.html
$remotefile = "/upload/index.html";
$remotedir = preg_replace('#[^\/]*\.html#', '', $remotefile);

//替换链接为空
echo preg_replace("'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1)(.*?)\\1|([^\s\>]+))[^>]*>?(.*?)</a>'isx", "$4", $content);

//$2为其本身的链接，$4为其本身的链接文字；这个正则可以精简原本的A标签,按自己的格式来输出
echo preg_replace("'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1)(.*?)\\1|([^\s\>]+))[^>]*>?(.*?)</a>'isx", "<a href=\"$2\" target='_blank'>$4</a>", $content);

//替换 某字符串 为 自定义字符串 并规定替换的最高次数
echo preg_replace('/Google/', '<a href="http://www.google.com/">谷歌</a>', $content, 4);
echo preg_replace("#".preg_quote($key)."#", $replace_key, $cur_str, $replace_num);//preg_quote 为转义正则中的关键字

//数组批量替换
$key = $replace_key = array();

$key[]="/谷歌/";
$key[]="/百度/";

$replace_key[]="<font color='red'>好谷歌</font>";
$replace_key[]="<font color='red'>坏百度</font>";

echo preg_replace($key, $replace_key, $content, 4);

//去除所有HTML标签
strip_tags($content);

echo preg_replace('/\$(\d)/', '\\\$$1', "$0.95");//--> \$0.95
echo preg_replace('/\s\s+/', ' ', 'foo   o');    //--> 'foo o'

//剔除链接
$content = preg_replace (array("'<a[^>]*?>'si", "'</a>'si"), array("", ""), $content);

//获取数字
//<a href="http://data.movie.xunlei.com/movie/48109"
preg_match("/<a href=\"(?<link>http:\/\/data\.movie\.xunlei\.com\/movie\/(?<id>\d+))\"/is", $li, $m_link);
$m_link['link']  $m_link['id']  //输出调用

/*
 * 空格，换行
 * 关于回车换行:
 * mac系统是 \r
 * windows \r\n
 * linux \n
 */
$arr = explode("\n", $key_str);//这个貌似比较靠谱
$arr = explode(chr(13), $key_str);


foreach ( explode("\r", $body) as $bodyline){
		$dataline = explode("|", $bodyline);
}



//将换行的ASCII码替换为HTML的换行符
$str = str_replace(chr(13), "<br>", $str);
//将空格的ASCII码替换为HTML的空格符
$str = str_replace(chr(32), "&nbsp;", $str);

//替换所有换行，不处理空格。适用于采集网页后对字符串的处理  dm456的效果
$str = preg_replace("'([\r\n])[\s]+'", "", $str);

//适用于生成网页时使用，压缩网页
$str = preg_replace("/[\n| ]{2,}/", "", $str);//无论多少个空格都能识别为一个空格

//清除所有空白字符。
$str = preg_replace("/\s/", "", $str);//一个空格就识别为一个空格


$out = strtolower(@ file_get_contents($url));
if ($out) {
	if (is_utf8($out))
		$out = mb_convert_encoding($out, "GBK", "UTF-8");
		preg_match_all('/<a(.*?)href=(.*?)>(.*?)<\/a>/i', $out, $m);
}


$str = '';
for ($i = 0; $i < count($content[1]); $i++) {
	$search = array (
		"'onmousedown=\"[^\"]*?\"'si",
		"'- <a href=(.*?)百度快照<\/a>'si"
	);
	$replace = array (
		"",
		""
	);
	$temp = preg_replace($search, $replace, $content[1][$i]);
	$temp = str_replace("新闻", "<font color='red'>新闻</font>", $temp);
	$str .= $temp . '<br />';
	if (preg_match("/163.com/", $temp)) {
		$str .= ($i +1) . "有匹配的网址<hr/>";
	} else {
		$str .= ($i +1) . "无匹配的网址<hr/>";
	}
}
echo $str;

////数组批量替换
$search = array (
	"'&nbsp; <a href=(.*?)预览<\/a>'si"
);
$replace = array (
	""
);
echo $str = preg_replace($search, $replace, $str);

/**
 * 压缩html : 清除换行符,清除制表符,去掉注释标记  
 * @param	$string  
 * @return  压缩后的$string 
 * */
function compress_html($string) {  
    $string = str_replace("\r\n", '', $string); //清除换行符  
    $string = str_replace("\n", '', $string); //清除换行符  
    $string = str_replace("\t", '', $string); //清除制表符  
    $pattern = array (  
                    "/> *([^ ]*) *</", //去掉注释标记  
                    "/[\s]+/",  
                    "/<!--[^!]*-->/",  
                    "/\" /",  
                    "/ \"/",  
                    "'/\*[^*]*\*/'"  
                    );  
    $replace = array (  
                    ">\\1<",  
                    " ",  
                    "",  
                    "\"",  
                    "\"",  
                    ""  
                    );  
    return preg_replace($pattern, $replace, $string);  
} 
?>
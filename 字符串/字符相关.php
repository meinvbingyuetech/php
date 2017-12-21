<?php

/*
文本转HTML													Text2Html
替换html标记												HtmlReplace
中文截取2，单字节截取模式									cn_substrR
中文截取1，单字节截取模式									cn_substr
utf-8中文截取，单字节截取模式								cn_substr_utf8
判断字符串是否含有中文										is_zhong
判断字符是否为全中文										is_allZhong
截取字符串													cut_str
判断字符串是否为UTF-8的编码(主要对中文字符进行判断)			is_utf8
中文转拼音													zh2pinyin	
修复浏览器XSS hack的函数									RemoveXSS
处理禁用HTML但允许换行的内容								TrimMsg
过滤用于搜索的字符串										FilterSearch
*/


/**
 *  过滤用于搜索的字符串
 *
 * @param     string  $keyword  关键词
 * @return    string
 */
function FilterSearch($keyword)
{
	global $cfg_soft_lang;
	if($cfg_soft_lang=='utf-8')
	{
		$keyword = preg_replace("/[\"\r\n\t\$\\><']/", '', $keyword);
		if($keyword != stripslashes($keyword))
		{
			return '';
		}
		else
		{
			return $keyword;
		}
	}
	else
	{
		$restr = '';
		for($i=0;isset($keyword[$i]);$i++)
		{
			if(ord($keyword[$i]) > 0x80)
			{
				if(isset($keyword[$i+1]) && ord($keyword[$i+1]) > 0x40)
				{
					$restr .= $keyword[$i].$keyword[$i+1];
					$i++;
				}
				else
				{
					$restr .= ' ';
				}
			}
			else
			{
				if(preg_match("/[^0-9a-z@#\.]/",$keyword[$i]))
				{
					$restr .= ' ';
				}
				else
				{
					$restr .= $keyword[$i];
				}
			}
		}
	}
	return $restr;
}

/**
 *  处理禁用HTML但允许换行的内容
 *
 * @access    public
 * @param     string  $msg  需要过滤的内容
 * @return    string
 */
function TrimMsg($msg)
{
	$msg = trim(stripslashes($msg));
	$msg = nl2br(htmlspecialchars($msg));
	$msg = str_replace("  ","&nbsp;&nbsp;",$msg);
	return addslashes($msg);
}

/**
 * 文本转HTML
 */
function Text2Html($txt)
{
	$txt = str_replace("&","&#38;",$txt);
	$txt = str_replace("  ","&#160;",$txt);
	$txt = str_replace(" ","&#160;",$txt);
	$txt = str_replace("\"","&#34;",$txt);
	$txt = str_replace("\'","&#39;",$txt);
	$txt = str_replace("<","&#60;",$txt);
	$txt = str_replace(">","&#62;",$txt);
	$txt = str_replace("×","&#215;",$txt);
	$txt = str_replace("÷","&#247;",$txt);
	$txt = str_replace("\n","<br/>",$txt);
	$txt = preg_replace("/[\r\n]{1,}/isU","<br/>\r\n",$txt);
	return $txt;
}

/**
 * 去除html中不规则内容字符
 * $rptype = 0 表示仅替换 html标记
 * $rptype = 1 表示替换 html标记同时去除连续空白字符
 * $rptype = 2 表示替换 html标记同时去除所有空白字符
 * $rptype = -1 表示仅替换 html危险的标记
 */
function HtmlReplace($str,$rptype=0)
{
	$str = stripslashes($str);
	$str = preg_replace("/<[\/]{0,1}style([^>]*)>(.*)<\/style>/i", '', $str);
	if($rptype==0)
	{
		$str = htmlspecialchars($str);
	}
	else if($rptype==1)
	{
		$str = htmlspecialchars($str);
		$str = str_replace("　",' ',$str);
		$str = ereg_replace("[\r\n\t ]{1,}",' ',$str);
	}
	else if($rptype==2)
	{
		$str = htmlspecialchars($str);
		$str = str_replace("　",'',$str);
		$str = ereg_replace("[\r\n\t ]",'',$str);
	}
	else
	{
		$str = ereg_replace("[\r\n\t ]{1,}",' ',$str);
		$str = eregi_replace('script','ｓｃｒｉｐｔ',$str);
		$str = eregi_replace("<[/]{0,1}(link|meta|ifr|fra)[^>]*>",'',$str);
	}
	return addslashes($str);
}


/**
 * 中文截取2，单字节截取模式
 * 如果是request的内容，必须使用这个函数
 */
function cn_substrR($str,$slen,$startdd=0)
{
	$str = cn_substr(stripslashes($str),$slen,$startdd);
	return addslashes($str);
}

/**
 * 中文截取1，单字节截取模式
 */
function cn_substr($str,$slen,$startdd=0,$lang)
{
	if($lang=='utf-8')
	{
		return cn_substr_utf8($str,$slen,$startdd);
	}
	$restr = '';
	$c = '';
	$str_len = strlen($str);
	if($str_len < $startdd+1)
	{
		return '';
	}
	if($str_len < $startdd + $slen || $slen==0)
	{
		$slen = $str_len - $startdd;
	}
	$enddd = $startdd + $slen - 1;
	for($i=0;$i<$str_len;$i++)
	{
		if($startdd==0)
		{
			$restr .= $c;
		}
		else if($i > $startdd)
		{
			$restr .= $c;
		}

		if(ord($str[$i])>0x80)
		{
			if($str_len>$i+1)
			{
				$c = $str[$i].$str[$i+1];
			}
			$i++;
		}
		else
		{
			$c = $str[$i];
		}

		if($i >= $enddd)
		{
			if(strlen($restr)+strlen($c)>$slen)
			{
				break;
			}
			else
			{
				$restr .= $c;
				break;
			}
		}
	}
	return $restr;
}

/**
 * utf-8中文截取，单字节截取模式
 */
function cn_substr_utf8($str, $length, $start=0)
{
	if(strlen($str) < $start+1)
	{
		return '';
	}
	preg_match_all("/./su", $str, $ar);
	$str = '';
	$tstr = '';

	//为了兼容mysql4.1以下版本,与数据库varchar一致,这里使用按字节截取
	for($i=0; isset($ar[0][$i]); $i++)
	{
		if(strlen($tstr) < $start)
		{
			$tstr .= $ar[0][$i];
		}
		else
		{
			if(strlen($str) < $length + strlen($ar[0][$i]) )
			{
				$str .= $ar[0][$i];
			}
			else
			{
				break;
			}
		}
	}
	return $str;
}

/**
 * 判断字符串是否含有中文
 * true为有中文
 * e.g: echo is_zhong("abc中文");
 */
function is_zhong($str, $encoding = 'gb2312') {
	if (mb_strlen($str, $encoding) != strlen($str)) {
		return true;
	} else {
		return false;
	}
}

/**
 * 判断字符是否为全中文
 * true为全中文
 * e.g: echo is_allZhong("是全中文吗？");
 */
function is_allZhong($str) {
	if (preg_match_all("/^([\x81-\xfe][\x40-\xfe])+$/", $str, $match)) {
		return true;
	} else {
		return false;
	}
}

/**
 * 截取字符串
 * 可以自由选择所切割的字符串的编码
 * 一个中文字符等于两个英文字符(英文字符切割要注意)
 * e.g : echo cut_str("我是中国人吗？",5);
 * 注意: 此函数是用来专门切割中文的，如果要切割英文，可以使用PHP内置函数 echo substr("abcdefg",0,4);
 * 		 如果遇到有HTML的字符串，则可以先用PHP内置函数剔除HTML echo strip_tags("<h1>你好,HTML！</h1>");
 */
function cut_str($string, $sublen, $replace = "", $start = 0, $code = 'gb2312') {
	if ($code == 'utf8') {
		$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
		preg_match_all($pa, $string, $t_string);

		if (count($t_string[0]) - $start > $sublen)
			return join('', array_slice($t_string[0], $start, $sublen)) . $replace;
		return join('', array_slice($t_string[0], $start, $sublen));
	} else {
		$start = $start * 2;
		$sublen = $sublen * 2;
		$strlen = strlen($string);
		$tmpstr = '';

		for ($i = 0; $i < $strlen; $i++) {
			if ($i >= $start && $i < ($start + $sublen)) {
				if (ord(substr($string, $i, 1)) > 129) {
					$tmpstr .= substr($string, $i, 2);
				} else {
					$tmpstr .= substr($string, $i, 1);
				}
			}
			if (ord(substr($string, $i, 1)) > 129)
				$i++;
		}
		if (strlen($tmpstr) < $strlen)
			$tmpstr .= $replace;
		return $tmpstr;
	}
}

/**
 * 判断字符串是否为UTF-8的编码(主要对中文字符进行判断)
 * 返回1则为是。
 * e.g: echo is_utf8(mb_convert_encoding("是否为中文呢","utf-8","gb2312"));
 */
function is_utf8($str) {
	$length = strlen($str);
	for ($i = 0; $i < $length; $i++) {
		$high = ord($str {
			$i });
		if (($high == 0xC0) || ($high == 0xC1)) {
			return false;
		}
		elseif ($high < 0x80) {
			continue;
		}
		elseif ($high < 0xC0) {
			return false;
		}
		elseif ($high < 0xE0) {
			if (++ $i >= $length)
				return true;
			elseif (($str {
				$i }
			& "\xC0") == "\x80") continue;
		}
		elseif ($high < 0xF0) {
			if (++ $i >= $length) {
				return true;
			}
			elseif (($str {
				$i }
			& "\xC0") == "\x80") {
				if (++ $i >= $length)
					return true;
				elseif (($str {
					$i }
				& "\xC0") == "\x80") continue;
			}
		}
		elseif ($high < 0xF5) {
			if (++ $i >= $length) {
				return true;
			}
			elseif (($str {
				$i }
			& "\xC0") == "\x80") {
				if (++ $i >= $length) {
					return true;
				}
				elseif (($str {
					$i }
				& "\xC0") == "\x80") {
					if (++ $i >= $length)
						return true;
					elseif (($str {
						$i }
					& "\xC0") == "\x80") continue;
				}
			}
		}
		return false;
	}
	return true;
}

/**
 * 函数名称：中文转拼音
 * 使用方法：echo zh2pinyin("美搜");
 */
function transform($num) {
	//global $dictionary;
	$dictionary = array (
		array (
			"a",
			-20319
		),
		array (
			"ai",
			-20317
		),
		array (
			"an",
			-20304
		),
		array (
			"ang",
			-20295
		),
		array (
			"ao",
			-20292
		),
		array (
			"ba",
			-20283
		),
		array (
			"bai",
			-20265
		),
		array (
			"ban",
			-20257
		),
		array (
			"bang",
			-20242
		),
		array (
			"bao",
			-20230
		),
		array (
			"bei",
			-20051
		),
		array (
			"ben",
			-20036
		),
		array (
			"beng",
			-20032
		),
		array (
			"bi",
			-20026
		),
		array (
			"bian",
			-20002
		),
		array (
			"biao",
			-19990
		),
		array (
			"bie",
			-19986
		),
		array (
			"bin",
			-19982
		),
		array (
			"bing",
			-19976
		),
		array (
			"bo",
			-19805
		),
		array (
			"bu",
			-19784
		),
		array (
			"ca",
			-19775
		),
		array (
			"cai",
			-19774
		),
		array (
			"can",
			-19763
		),
		array (
			"cang",
			-19756
		),
		array (
			"cao",
			-19751
		),
		array (
			"ce",
			-19746
		),
		array (
			"ceng",
			-19741
		),
		array (
			"cha",
			-19739
		),
		array (
			"chai",
			-19728
		),
		array (
			"chan",
			-19725
		),
		array (
			"chang",
			-19715
		),
		array (
			"chao",
			-19540
		),
		array (
			"che",
			-19531
		),
		array (
			"chen",
			-19525
		),
		array (
			"cheng",
			-19515
		),
		array (
			"chi",
			-19500
		),
		array (
			"chong",
			-19484
		),
		array (
			"chou",
			-19479
		),
		array (
			"chu",
			-19467
		),
		array (
			"chuai",
			-19289
		),
		array (
			"chuan",
			-19288
		),
		array (
			"chuang",
			-19281
		),
		array (
			"chui",
			-19275
		),
		array (
			"chun",
			-19270
		),
		array (
			"chuo",
			-19263
		),
		array (
			"ci",
			-19261
		),
		array (
			"cong",
			-19249
		),
		array (
			"cou",
			-19243
		),
		array (
			"cu",
			-19242
		),
		array (
			"cuan",
			-19238
		),
		array (
			"cui",
			-19235
		),
		array (
			"cun",
			-19227
		),
		array (
			"cuo",
			-19224
		),
		array (
			"da",
			-19218
		),
		array (
			"dai",
			-19212
		),
		array (
			"dan",
			-19038
		),
		array (
			"dang",
			-19023
		),
		array (
			"dao",
			-19018
		),
		array (
			"de",
			-19006
		),
		array (
			"deng",
			-19003
		),
		array (
			"di",
			-18996
		),
		array (
			"dian",
			-18977
		),
		array (
			"diao",
			-18961
		),
		array (
			"die",
			-18952
		),
		array (
			"ding",
			-18783
		),
		array (
			"diu",
			-18774
		),
		array (
			"dong",
			-18773
		),
		array (
			"dou",
			-18763
		),
		array (
			"du",
			-18756
		),
		array (
			"duan",
			-18741
		),
		array (
			"dui",
			-18735
		),
		array (
			"dun",
			-18731
		),
		array (
			"duo",
			-18722
		),
		array (
			"e",
			-18710
		),
		array (
			"en",
			-18697
		),
		array (
			"er",
			-18696
		),
		array (
			"fa",
			-18526
		),
		array (
			"fan",
			-18518
		),
		array (
			"fang",
			-18501
		),
		array (
			"fei",
			-18490
		),
		array (
			"fen",
			-18478
		),
		array (
			"feng",
			-18463
		),
		array (
			"fo",
			-18448
		),
		array (
			"fou",
			-18447
		),
		array (
			"fu",
			-18446
		),
		array (
			"ga",
			-18239
		),
		array (
			"gai",
			-18237
		),
		array (
			"gan",
			-18231
		),
		array (
			"gang",
			-18220
		),
		array (
			"gao",
			-18211
		),
		array (
			"ge",
			-18201
		),
		array (
			"gei",
			-18184
		),
		array (
			"gen",
			-18183
		),
		array (
			"geng",
			-18181
		),
		array (
			"gong",
			-18012
		),
		array (
			"gou",
			-17997
		),
		array (
			"gu",
			-17988
		),
		array (
			"gua",
			-17970
		),
		array (
			"guai",
			-17964
		),
		array (
			"guan",
			-17961
		),
		array (
			"guang",
			-17950
		),
		array (
			"gui",
			-17947
		),
		array (
			"gun",
			-17931
		),
		array (
			"guo",
			-17928
		),
		array (
			"ha",
			-17922
		),
		array (
			"hai",
			-17759
		),
		array (
			"han",
			-17752
		),
		array (
			"hang",
			-17733
		),
		array (
			"hao",
			-17730
		),
		array (
			"he",
			-17721
		),
		array (
			"hei",
			-17703
		),
		array (
			"hen",
			-17701
		),
		array (
			"heng",
			-17697
		),
		array (
			"hong",
			-17692
		),
		array (
			"hou",
			-17683
		),
		array (
			"hu",
			-17676
		),
		array (
			"hua",
			-17496
		),
		array (
			"huai",
			-17487
		),
		array (
			"huan",
			-17482
		),
		array (
			"huang",
			-17468
		),
		array (
			"hui",
			-17454
		),
		array (
			"hun",
			-17433
		),
		array (
			"huo",
			-17427
		),
		array (
			"ji",
			-17417
		),
		array (
			"jia",
			-17202
		),
		array (
			"jian",
			-17185
		),
		array (
			"jiang",
			-16983
		),
		array (
			"jiao",
			-16970
		),
		array (
			"jie",
			-16942
		),
		array (
			"jin",
			-16915
		),
		array (
			"jing",
			-16733
		),
		array (
			"jiong",
			-16708
		),
		array (
			"jiu",
			-16706
		),
		array (
			"ju",
			-16689
		),
		array (
			"juan",
			-16664
		),
		array (
			"jue",
			-16657
		),
		array (
			"jun",
			-16647
		),
		array (
			"ka",
			-16474
		),
		array (
			"kai",
			-16470
		),
		array (
			"kan",
			-16465
		),
		array (
			"kang",
			-16459
		),
		array (
			"kao",
			-16452
		),
		array (
			"ke",
			-16448
		),
		array (
			"ken",
			-16433
		),
		array (
			"keng",
			-16429
		),
		array (
			"kong",
			-16427
		),
		array (
			"kou",
			-16423
		),
		array (
			"ku",
			-16419
		),
		array (
			"kua",
			-16412
		),
		array (
			"kuai",
			-16407
		),
		array (
			"kuan",
			-16403
		),
		array (
			"kuang",
			-16401
		),
		array (
			"kui",
			-16393
		),
		array (
			"kun",
			-16220
		),
		array (
			"kuo",
			-16216
		),
		array (
			"la",
			-16212
		),
		array (
			"lai",
			-16205
		),
		array (
			"lan",
			-16202
		),
		array (
			"lang",
			-16187
		),
		array (
			"lao",
			-16180
		),
		array (
			"le",
			-16171
		),
		array (
			"lei",
			-16169
		),
		array (
			"leng",
			-16158
		),
		array (
			"li",
			-16155
		),
		array (
			"lia",
			-15959
		),
		array (
			"lian",
			-15958
		),
		array (
			"liang",
			-15944
		),
		array (
			"liao",
			-15933
		),
		array (
			"lie",
			-15920
		),
		array (
			"lin",
			-15915
		),
		array (
			"ling",
			-15903
		),
		array (
			"liu",
			-15889
		),
		array (
			"long",
			-15878
		),
		array (
			"lou",
			-15707
		),
		array (
			"lu",
			-15701
		),
		array (
			"lv",
			-15681
		),
		array (
			"luan",
			-15667
		),
		array (
			"lue",
			-15661
		),
		array (
			"lun",
			-15659
		),
		array (
			"luo",
			-15652
		),
		array (
			"ma",
			-15640
		),
		array (
			"mai",
			-15631
		),
		array (
			"man",
			-15625
		),
		array (
			"mang",
			-15454
		),
		array (
			"mao",
			-15448
		),
		array (
			"me",
			-15436
		),
		array (
			"mei",
			-15435
		),
		array (
			"men",
			-15419
		),
		array (
			"meng",
			-15416
		),
		array (
			"mi",
			-15408
		),
		array (
			"mian",
			-15394
		),
		array (
			"miao",
			-15385
		),
		array (
			"mie",
			-15377
		),
		array (
			"min",
			-15375
		),
		array (
			"ming",
			-15369
		),
		array (
			"miu",
			-15363
		),
		array (
			"mo",
			-15362
		),
		array (
			"mou",
			-15183
		),
		array (
			"mu",
			-15180
		),
		array (
			"na",
			-15165
		),
		array (
			"nai",
			-15158
		),
		array (
			"nan",
			-15153
		),
		array (
			"nang",
			-15150
		),
		array (
			"nao",
			-15149
		),
		array (
			"ne",
			-15144
		),
		array (
			"nei",
			-15143
		),
		array (
			"nen",
			-15141
		),
		array (
			"neng",
			-15140
		),
		array (
			"ni",
			-15139
		),
		array (
			"nian",
			-15128
		),
		array (
			"niang",
			-15121
		),
		array (
			"niao",
			-15119
		),
		array (
			"nie",
			-15117
		),
		array (
			"nin",
			-15110
		),
		array (
			"ning",
			-15109
		),
		array (
			"niu",
			-14941
		),
		array (
			"nong",
			-14937
		),
		array (
			"nu",
			-14933
		),
		array (
			"nv",
			-14930
		),
		array (
			"nuan",
			-14929
		),
		array (
			"nue",
			-14928
		),
		array (
			"nuo",
			-14926
		),
		array (
			"o",
			-14922
		),
		array (
			"ou",
			-14921
		),
		array (
			"pa",
			-14914
		),
		array (
			"pai",
			-14908
		),
		array (
			"pan",
			-14902
		),
		array (
			"pang",
			-14894
		),
		array (
			"pao",
			-14889
		),
		array (
			"pei",
			-14882
		),
		array (
			"pen",
			-14873
		),
		array (
			"peng",
			-14871
		),
		array (
			"pi",
			-14857
		),
		array (
			"pian",
			-14678
		),
		array (
			"piao",
			-14674
		),
		array (
			"pie",
			-14670
		),
		array (
			"pin",
			-14668
		),
		array (
			"ping",
			-14663
		),
		array (
			"po",
			-14654
		),
		array (
			"pu",
			-14645
		),
		array (
			"qi",
			-14630
		),
		array (
			"qia",
			-14594
		),
		array (
			"qian",
			-14429
		),
		array (
			"qiang",
			-14407
		),
		array (
			"qiao",
			-14399
		),
		array (
			"qie",
			-14384
		),
		array (
			"qin",
			-14379
		),
		array (
			"qing",
			-14368
		),
		array (
			"qiong",
			-14355
		),
		array (
			"qiu",
			-14353
		),
		array (
			"qu",
			-14345
		),
		array (
			"quan",
			-14170
		),
		array (
			"que",
			-14159
		),
		array (
			"qun",
			-14151
		),
		array (
			"ran",
			-14149
		),
		array (
			"rang",
			-14145
		),
		array (
			"rao",
			-14140
		),
		array (
			"re",
			-14137
		),
		array (
			"ren",
			-14135
		),
		array (
			"reng",
			-14125
		),
		array (
			"ri",
			-14123
		),
		array (
			"rong",
			-14122
		),
		array (
			"rou",
			-14112
		),
		array (
			"ru",
			-14109
		),
		array (
			"ruan",
			-14099
		),
		array (
			"rui",
			-14097
		),
		array (
			"run",
			-14094
		),
		array (
			"ruo",
			-14092
		),
		array (
			"sa",
			-14090
		),
		array (
			"sai",
			-14087
		),
		array (
			"san",
			-14083
		),
		array (
			"sang",
			-13917
		),
		array (
			"sao",
			-13914
		),
		array (
			"se",
			-13910
		),
		array (
			"sen",
			-13907
		),
		array (
			"seng",
			-13906
		),
		array (
			"sha",
			-13905
		),
		array (
			"shai",
			-13896
		),
		array (
			"shan",
			-13894
		),
		array (
			"shang",
			-13878
		),
		array (
			"shao",
			-13870
		),
		array (
			"she",
			-13859
		),
		array (
			"shen",
			-13847
		),
		array (
			"sheng",
			-13831
		),
		array (
			"shi",
			-13658
		),
		array (
			"shou",
			-13611
		),
		array (
			"shu",
			-13601
		),
		array (
			"shua",
			-13406
		),
		array (
			"shuai",
			-13404
		),
		array (
			"shuan",
			-13400
		),
		array (
			"shuang",
			-13398
		),
		array (
			"shui",
			-13395
		),
		array (
			"shun",
			-13391
		),
		array (
			"shuo",
			-13387
		),
		array (
			"si",
			-13383
		),
		array (
			"song",
			-13367
		),
		array (
			"sou",
			-13359
		),
		array (
			"su",
			-13356
		),
		array (
			"suan",
			-13343
		),
		array (
			"sui",
			-13340
		),
		array (
			"sun",
			-13329
		),
		array (
			"suo",
			-13326
		),
		array (
			"ta",
			-13318
		),
		array (
			"tai",
			-13147
		),
		array (
			"tan",
			-13138
		),
		array (
			"tang",
			-13120
		),
		array (
			"tao",
			-13107
		),
		array (
			"te",
			-13096
		),
		array (
			"teng",
			-13095
		),
		array (
			"ti",
			-13091
		),
		array (
			"tian",
			-13076
		),
		array (
			"tiao",
			-13068
		),
		array (
			"tie",
			-13063
		),
		array (
			"ting",
			-13060
		),
		array (
			"tong",
			-12888
		),
		array (
			"tou",
			-12875
		),
		array (
			"tu",
			-12871
		),
		array (
			"tuan",
			-12860
		),
		array (
			"tui",
			-12858
		),
		array (
			"tun",
			-12852
		),
		array (
			"tuo",
			-12849
		),
		array (
			"wa",
			-12838
		),
		array (
			"wai",
			-12831
		),
		array (
			"wan",
			-12829
		),
		array (
			"wang",
			-12812
		),
		array (
			"wei",
			-12802
		),
		array (
			"wen",
			-12607
		),
		array (
			"weng",
			-12597
		),
		array (
			"wo",
			-12594
		),
		array (
			"wu",
			-12585
		),
		array (
			"xi",
			-12556
		),
		array (
			"xia",
			-12359
		),
		array (
			"xian",
			-12346
		),
		array (
			"xiang",
			-12320
		),
		array (
			"xiao",
			-12300
		),
		array (
			"xie",
			-12120
		),
		array (
			"xin",
			-12099
		),
		array (
			"xing",
			-12089
		),
		array (
			"xiong",
			-12074
		),
		array (
			"xiu",
			-12067
		),
		array (
			"xu",
			-12058
		),
		array (
			"xuan",
			-12039
		),
		array (
			"xue",
			-11867
		),
		array (
			"xun",
			-11861
		),
		array (
			"ya",
			-11847
		),
		array (
			"yan",
			-11831
		),
		array (
			"yang",
			-11798
		),
		array (
			"yao",
			-11781
		),
		array (
			"ye",
			-11604
		),
		array (
			"yi",
			-11589
		),
		array (
			"yin",
			-11536
		),
		array (
			"ying",
			-11358
		),
		array (
			"yo",
			-11340
		),
		array (
			"yong",
			-11339
		),
		array (
			"you",
			-11324
		),
		array (
			"yu",
			-11303
		),
		array (
			"yuan",
			-11097
		),
		array (
			"yue",
			-11077
		),
		array (
			"yun",
			-11067
		),
		array (
			"za",
			-11055
		),
		array (
			"zai",
			-11052
		),
		array (
			"zan",
			-11045
		),
		array (
			"zang",
			-11041
		),
		array (
			"zao",
			-11038
		),
		array (
			"ze",
			-11024
		),
		array (
			"zei",
			-11020
		),
		array (
			"zen",
			-11019
		),
		array (
			"zeng",
			-11018
		),
		array (
			"zha",
			-11014
		),
		array (
			"zhai",
			-10838
		),
		array (
			"zhan",
			-10832
		),
		array (
			"zhang",
			-10815
		),
		array (
			"zhao",
			-10800
		),
		array (
			"zhe",
			-10790
		),
		array (
			"zhen",
			-10780
		),
		array (
			"zheng",
			-10764
		),
		array (
			"zhi",
			-10587
		),
		array (
			"zhong",
			-10544
		),
		array (
			"zhou",
			-10533
		),
		array (
			"zhu",
			-10519
		),
		array (
			"zhua",
			-10331
		),
		array (
			"zhuai",
			-10329
		),
		array (
			"zhuan",
			-10328
		),
		array (
			"zhuang",
			-10322
		),
		array (
			"zhui",
			-10315
		),
		array (
			"zhun",
			-10309
		),
		array (
			"zhuo",
			-10307
		),
		array (
			"zi",
			-10296
		),
		array (
			"zong",
			-10281
		),
		array (
			"zou",
			-10274
		),
		array (
			"zu",
			-10270
		),
		array (
			"zuan",
			-10262
		),
		array (
			"zui",
			-10260
		),
		array (
			"zun",
			-10256
		),
		array (
			"zuo",
			-10254
		)
	);
	if ($num > 0 && $num < 160) {
		return chr($num);
	}
	elseif ($num < -20319 || $num > -10247) {
		return "";
	} else {
		for ($i = count($dictionary) - 1; $i >= 0; $i--) {
			if ($dictionary[$i][1] <= $num) {
				break;
			}
		}
		return $dictionary[$i][0];
	}
}
function zh2pinyin($string) {
	$output = "";
	for ($i = 0; $i < strlen($string); $i++) {
		$letter = ord(substr($string, $i, 1));
		if ($letter > 160) {
			$tmp = ord(substr($string, ++ $i, 1));
			$letter = $letter * 256 + $tmp -65536;
		}
		$output .= transform($letter);
	}
	return $output;
}

/**
 *  修复浏览器XSS hack的函数
 *
 * @param     string   $val  需要处理的内容
 * @return    string
 */
function RemoveXSS($val) {
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
	  $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
	  $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; 
   while ($found == true) {
	  $val_before = $val;
	  for ($i = 0; $i < sizeof($ra); $i++) {
		 $pattern = '/';
		 for ($j = 0; $j < strlen($ra[$i]); $j++) {
			if ($j > 0) {
			   $pattern .= '(';
			   $pattern .= '(&#[xX]0{0,8}([9ab]);)';
			   $pattern .= '|';
			   $pattern .= '|(&#0{0,8}([9|10|13]);)';
			   $pattern .= ')*';
			}
			$pattern .= $ra[$i][$j];
		 }
		 $pattern .= '/i';
		 $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
		 $val = preg_replace($pattern, $replacement, $val); 
		 if ($val_before == $val) {
			$found = false;
		 }
	  }
   }
   return $val;
}
?>

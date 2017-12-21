<?php
// 定义变量并默认设置为空值
$name = $comment = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $name = test_input($_POST["name"]);
  $comment = test_input($_POST["comment"]);
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/**********************************************************************************/

//获取数据
$content =  addslashes(htmlspecialchars($_POST['myEditor']));

//地址栏进来的数据，还要urldecode

//显示
echo  "<div class='content'>".htmlspecialchars_decode($content)."</div>";

/**********************************************************************************/


/**
 * 对 MYSQL LIKE 的内容进行转义
 *
 * @access      public
 * @param       string      string  内容
 * @return      string
 */
function mysql_like_quote($str)
{
    return strtr($str, array("\\\\" => "\\\\\\\\", '_' => '\_', '%' => '\%', "\'" => "\\\\\'"));
}

/**
 * 过滤用户输入的基本数据，防止script攻击
 *
 * @access      public
 * @return      string
 */
function compile_str($str)
{
    $arr = array('<' => '＜', '>' => '＞','"'=>'”',"'"=>'’');

    return strtr($str, $arr);
}


/**
 * 递归方式的对变量中的特殊字符进行转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function addslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    }
}

/**
 * 将对象成员变量或者数组的特殊字符进行转义
 *
 * @access   public
 * @param    mix        $obj      对象或者数组
 * @author   Xuan Yan
 *
 * @return   mix                  对象或者数组
 */
function addslashes_deep_obj($obj)
{
    if (is_object($obj) == true)
    {
        foreach ($obj AS $key => $val)
        {
            $obj->$key = addslashes_deep($val);
        }
    }
    else
    {
        $obj = addslashes_deep($obj);
    }

    return $obj;
}

/**
 * 递归方式的对变量中的特殊字符去除转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function stripslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
    }
}

/**
 * 去除字符串右侧可能出现的乱码
 *
 * @param   string      $str        字符串
 *
 * @return  string
 */
function trim_right($str)
{
    $len = strlen($str);
    /* 为空或单个字符直接返回 */
    if ($len == 0 || ord($str{$len-1}) < 127)
    {
        return $str;
    }
    /* 有前导字符的直接把前导字符去掉 */
    if (ord($str{$len-1}) >= 192)
    {
       return substr($str, 0, $len-1);
    }
    /* 有非独立的字符，先把非独立字符去掉，再验证非独立的字符是不是一个完整的字，不是连原来前导字符也截取掉 */
    $r_len = strlen(rtrim($str, "\x80..\xBF"));
    if ($r_len == 0 || ord($str{$r_len-1}) < 127)
    {
        return sub_str($str, 0, $r_len);
    }

    $as_num = ord(~$str{$r_len -1});
    if ($as_num > (1<<(6 + $r_len - $len)))
    {
        return $str;
    }
    else
    {
        return substr($str, 0, $r_len-1);
    }
}

/**
 * 关键字加红
 * echo GetRedKeyWord($content,"关键字1,关键字2,关键字3");
 */
function GetRedKeyWord($content, $Keywords) {
	$ks = explode(",", $Keywords);
	foreach ($ks as $k) {
		$k = trim($k);
		if ($k == "")
			continue;
		if (ord($k[0]) > 0x80 && strlen($k) < 3)
			continue;
		$content = str_replace($k, "<font color='red'>$k</font>", $content);
	}
	return $content;
}

/**
 * 过滤用于搜索的字符串
 */
function FilterSearch($keyword,$lang)
{
	if($lang=='utf-8')
	{
		$keyword = ereg_replace("[\"\r\n\t\$\\><']",'',$keyword);
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
				if(eregi("[^0-9a-z@#\.]",$keyword[$i]))
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
 * 过滤搜索关键词
 * 本函数将过滤空格，规则严厉，用于精确查询！
 * ck_search_key($str,$len)
 * 第一个参数是要检查的关键词字符串
 * 第二个参数为可选项，如果关键词超过设定的长度则切割。默认是30字符，即15个中文
 */
function ck_search_key($k,$len=30){
	$keyword = cn_substr(trim(ereg_replace("[><\|\"\r\n\t%\*\.\?\(\)\$ ;,'%-]", "", stripslashes($k))), $len);
	$keyword = addslashes($keyword);
	return $keyword;
}

/**
* 过滤左右两边的空格，换行
*/
function mytrim($m) {
	$str = preg_replace("'([\r\n])[\s]+'", "", $m);
	$str = preg_replace("/[\n| ]{2,}/", "", $str);
	$str = preg_replace("/\s/", " ", $str);
	return $str;
}

/**
 * 防止注入(供传入参数时检测数据的合法性)
 * e.g: inject_check("select");
 */
function inject_check($check_str) {
	$check = eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $check_str);
	if ($check) {
		return true;
	} else {
		return false;
	}
}

/**
 * 判断是否含有非法关键字 true-->有非法关键字
 * e.g: echo is_varikey("我草");
 */
function is_varikey($check_str) {

	$arr_msg = array (
		"我草",
		"你妈的"
	);

	for ($i = 0; $i < sizeof($arr_msg); $i++) {
		if (preg_match("/($arr_msg[$i])/", $check_str)) {
			return true;
			break;
		}
	}

	return false;
}

/**
 * 判断是否含有非法关键字(评论，如果有，则用**代替)
 * e.g: echo replace_varikey("我草!你是不是人啊");
 */
function replace_varikey($check_str) {
	$arr_msg = array (
		"我草",
		"你妈的"
	);

	for ($i = 0; $i < sizeof($arr_msg); $i++) {
		$check_str = preg_replace("/($arr_msg[$i])/i", "***", $check_str);
	}

	return $check_str;
}
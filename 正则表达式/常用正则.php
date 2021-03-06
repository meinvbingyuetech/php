$str = '';
$isMatched = preg_match('/[\u4e00-\u9fa5]/', $str, $matches);
var_dump($isMatched, $matches);


中文字符	[\u4e00-\u9fa5]
双字节字符	[^\x00-\xff]
空白行		\s
Email地址	\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}
网址URL		^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+
手机（国内）	0?(13|14|15|17|18)[0-9]{9}
电话号码（国内）[0-9-()（）]{7,18}
负浮点数	-([1-9]\d*.\d*|0.\d*[1-9]\d*)
匹配整数	-?[1-9]\d*
正浮点数	[1-9]\d*.\d*|0.\d*[1-9]\d*
腾讯QQ号	[1-9]([0-9]{5,11})
邮政编码	\d{6}
IP		(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)
身份证号	\d{17}[\d|x]|\d{15}
格式日期	\d{4}(\-|\/|.)\d{1,2}\1\d{1,2}	
正整数		[1-9]\d*
负整数		-[1-9]\d*
用户名		[A-Za-z0-9_\-\u4e00-\u9fa5]+
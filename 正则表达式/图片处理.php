<?php
/*********************************一些案例***************************************************/
preg_replace("/<(img|IMG)(.*)(src|SRC)=[\"|'| ]{0,}((.*)>)/isU", "<a href='http://www.baidu.com/'>" . "\${0}" . "</a>", $body);
//$newstext=preg_replace(preg_replace('/(<img[^>]+src\s*=\s*”?([^>"\s]+)”?[^>]*>)/im', '<a href="$2">$1</a>', $newstext);
preg_match_all("/<img(.*?)src=\"(.*?)\"(.*?)>/", $real_conent, $n);

preg_match_all("/<img.*src\s*=\s*[\"|\']?\s*([^>\"\'\s]*)/i", $v, $m);//有用
$imgUrl = $m[1][0];

/*********************************采集贴吧的***************************************************/
$cont = preg_replace('/ height="(\d+)"/i', "", $cont);
$cont = preg_replace('/ width="(\d+)"/i', "", $cont);
$cont = preg_replace('/ class="BDE_Image"/i', "", $cont);
$cont = preg_replace('/ pic_type="0"/i', "", $cont);
$cont = preg_replace('/ pic_ext="(.*?)"/i', "", $cont);
$cont = preg_replace('/ bdwater="(.*?)"/i', "", $cont);

//$cont = preg_replace("/<(img|IMG)(.*)(src|SRC)=[\"|'| ]{0,}((.*)>)/isU", "{img|\${4}}", $cont);
$cont = preg_replace("/<img([^>]*)\s*src=('|\")([^'\"]+)('|\")(.*?)>/", "{img|\${3}}", $cont);//这个目前看是比较好的

$cont = str_replace('|"http', '|http', $cont);
$cont = str_replace('" >}', '}', $cont);

$cont = str_replace('{', '{#', $cont);
$cont = str_replace('}', '#}', $cont);
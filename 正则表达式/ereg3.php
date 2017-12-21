<?php
exit;
include_once dirname(__FILE__)."/include/common.inc.php";

$sql = "SELECT aid,body from #@__addonarticle";
$dsql->SetQuery($sql);
$dsql->Execute();
while ($row = $dsql->GetArray()) {
	$body = $row['body'];

	preg_match_all("/(src)=[\"|'| ]{0,}([^>]*\.(gif|jpg|bmp|png))/isU",$body,$match);
	foreach($match[2] as $k=>$v){
		$v = str_replace('"',"",$v);
		$body = str_replace('onclick="window.open(\''.$v.'\')"',"",$body);
	}

	$body = addslashes($body);

	$sqlU = "update #@__addonarticle set body='".$body."' where aid=".$row['aid'];
	echo $dsql->ExecuteNoneQuery($sqlU);
	echo "<hr>";
}


exit;
$str = '<p style="text-align: center"><img style="cursor: pointer" border="0" alt="" width="400" height="600" onclick="window.open(\'/uploads/allimg/120710/4_120710093953_1.jpg\')" src="/uploads/allimg/120710/4_120710093953_1.jpg" /></p>
';
preg_match('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i',$str,$match);
$src = $match[1];
str_replace('onclick="window.open(\''.$src.'\')"',"",$str);

//preg_replace('/(<img.+src=\"?.+)(images\/)(.+\.(jpg|gif|bmp|bnp|png)\"?.+>)/i',"\${1}uc/images/\${3}",$str);
//preg_replace('/(<img).+(src=\"?.+)images\/(.+\.(jpg|gif|bmp|bnp|png)\"?).+>/i',"\${1} \${2}uc/images/\${3}>",$str);
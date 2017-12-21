<?php

//读出所有时间
$arrtime = $arryear = array();
$dsql->Execute('me', "select ctime from #@__user_logs where uid=".$uid." order by ctime desc");
while ($row = $dsql->GetArray('me')) {
	$arryear[] = date("Y",$row['ctime']);
	$arrtime[] = date("Ym",$row['ctime']);
}

$arryear = array_unique($arryear);
$arrtime = array_unique($arrtime);

/***********************************************************************************************************************/
/*
<dd id="year2011" ><a>2011年</a>
	<div class="mList"> <a class="m5">5月</a> <a class="m4">4月</a> </div>
</dd>
*/
foreach($arryear as $k=>$v){////--->关键部分
	
	$beginTimeYear = strtotime($v."-01-01");
	$endTimeYear = strtotime($v."-12-31");
	echo '<dd id="year'.$v.'" class="cur"><a href="?bt='.$beginTimeYear.'&et='.$endTimeYear.'&uid='.$uid.'">'.$v.'年</a><div class="mList">';
	$i = 0;
	foreach($arrtime as $k2=>$v2){////--->关键部分
		$class_2 = '';
		if(strstr($v2,$v)){////--->关键部分
			$mon = $mon2 = str_replace($v,"",$v2);////--->关键部分
			if($mon!=10){
				$mon = substr($mon,1,1);
			}

			$beginTimeMonth = strtotime($v."-".$mon."-01");
			$endTimeMonth = strtotime($v."-".$mon."-".month_day($v."-".$mon));
			if($i==0 && $bt=='' && $et==''){
				$class_2 = ' cur';
			}
			else if($mon2==date("m",$bt)){
				$class_2 = ' cur';
			}
			echo '<a class="m'.$mon.$class_2.'" href="?bt='.$beginTimeMonth.'&et='.$endTimeMonth.'&uid='.$uid.'">'.$mon.'月</a>';
		}
		$i++;
	}
	echo '</div></dd>';
}
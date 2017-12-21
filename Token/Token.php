<?php

/**
 * 校验DIY验证TOKEN与传递过来的TOKEN是否一致
 * @param	string	$token		待校验TOKEN
 * @param	array	$param		数组，可以传递若干个参数(目前支持3个)，千万注意顺序，按什么顺序获取TOKEN，就要按什么顺序校验
 * @return boolean
 */
function check_diy_token($token,$param){
    $flag = true;
	$cur_token = get_diy_token($param);
    if($token!=$cur_token){
		$flag = false;
	}
    return $flag;
} 

/**
 * 获取DIY验证TOKEN
 * @author  meinvbingyue
 * @param	array	$param		数组，可以传递若干个参数(目前支持3个)，千万注意顺序，按什么顺序获取TOKEN，就要按什么顺序校验
 * @return string
 */
function get_diy_token($param){
	if(count($param)==1){//1个参数的时候
		return substr(md5($param[0]),3,22).substr(md5($param[0]), 9,15);
	}
	elseif(count($param)==2){//2个参数的时候
		return substr(md5($param[0]),7,20).substr(md5($param[0].$param[1]), 6,14);
	}
	elseif(count($param)==3){//3个参数的时候
		return md5($param[0].$param[1]).substr(md5($param[1].$param[2]), 4,21);
	}   
}

//获取--赋值
$token = get_diy_token(array($_SESSION['forget_pwd_step']));
$smarty->assign("token",$token);

//判断
if(!check_diy_token($_GET['token'],array($_SESSION['forget_pwd_step']))){
	$result['error']   = '1011';
	$result['message'] = '非法请求';
	die(json_encode($result));
}
?>
<script type="text/javascript">
<!--
		$.ajax({
		async:"false",
		url:"/api/user/forget_pwd?token=a4238a0b923820dcc509a60b923820dcc509a",// api/Module/Controller/Action
		data:{username:username},
		dataType:"json",
		type:"post",
		success:
		function(data){
			
		}
	});

//-->
</script>
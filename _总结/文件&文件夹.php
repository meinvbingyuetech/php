<?php

//缓存一些数据，如果没有文件就创建文件，如果文件内容过期再抓取新内容
function wx_token(){
	global $wx_mp_AppId,$wx_mp_AppSecret;

	$is_curl_token = false;//是否要重新抓取token
	$file_token = dirname(__FILE__)."/cache/token.txt";
	if(!file_exists($file_token)){//文件是否存在
		$is_curl_token = true;
	}
	else{
		
		if(time()-filemtime($file_token)>7200){//文件是否过期（2小时）
			$is_curl_token = true;
		}
		else{
			$is_curl_token = false;
		}
	}
	
	if($is_curl_token){
		$url_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$wx_mp_AppId}&secret={$wx_mp_AppSecret}";
		$content = curl_get($url_token);
		$arr = json_decode($content,true);
		$token = $arr['access_token'];
		file_put_contents($file_token,$token);
		echo "remote";
	}
	else{
		$token = file_get_contents($file_token);
		echo "local";
	}

	echo "<hr>Token:{$token}";
}

//循环删除文件夹下的文件
chdir(dirname(dirname(__FILE__))."/scache");
foreach (glob("*/*" .cache) as $file) {
	unlink($file);
}

/**
* recursiveDelete(递归删除)
* 删除文件或递归删除目录
* @param string $str Path to file or directory
*/
function recursiveDelete($str) {
	if (is_file($str)) {
		return @ unlink($str);
	}
	elseif (is_dir($str)) {
		$scan = glob(rtrim($str, '/') . '/*');
		foreach ($scan as $index => $path) {
			recursiveDelete($path);
		}
		return @ rmdir($str);
	}
}

/**
 * 循环创建目录
 * echo make_dir(ROOT."/text/text1/text2");
 * 返回1 说明创建成功
 */
function make_dir($folder) {
	$reval = false;

	if (!file_exists($folder)) {
		/** 如果目录不存在则尝试创建该目录 */
		@ umask(0);

		/** 将目录路径拆分成数组 */
		preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);

		/** 如果第一个字符为/则当作物理路径处理 */
		$base = ($atmp[0][0] == '/') ? '/' : '';

		/** 遍历包含路径信息的数组 */
		foreach ($atmp[1] AS $val) {
			if ('' != $val) {
				$base .= $val;

				if ('..' == $val || '.' == $val) {
					/** 如果目录为.或者..则直接补/继续下一个循环 */
					$base .= '/';

					continue;
				}
			} else {
				continue;
			}

			$base .= '/';

			if (!file_exists($base)) {
				/** 尝试创建目录，如果创建失败则继续循环 */
				if (@ mkdir(rtrim($base, '/'), 0777)) {
					@ chmod($base, 0777);
					$reval = true;
				}
			}
		}
	} else {
		/** 路径已经存在。返回该路径是不是一个目录 */
		$reval = is_dir($folder);
	}

	clearstatcache();

	return $reval;
}

/***
 * 参数：
 * 文件名，文件流
 */
function makeFile($file_name, $c) {
	$status = 0;  //0,成功 1,文件打开失败！ 2, "文件写入失败！"
	if (!$fp = fopen($file_name,"w")) {
		$status = 1 ;
	}
	if (fwrite($fp,$c)==FALSE) {
		$status = 2;
	}
	fclose($fp);
	return $status;
}


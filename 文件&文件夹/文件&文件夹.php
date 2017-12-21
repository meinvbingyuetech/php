<?php

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


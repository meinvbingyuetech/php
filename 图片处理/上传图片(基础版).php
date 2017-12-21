<?php
//$_FILES["litpic"]["error"]==0  说明有图片上传
if ($_FILES["litpic"]["error"] > 0)
{
	echo "请选择上传的图片";
}
else
{
	$arr_imgtype = array("image/gif","image/jpeg","image/pjpeg","image/png");
	if(!in_array($_FILES["litpic"]["type"], $arr_imgtype)){
		echo "格式不正确";exit;
	}
	if(($_FILES["litpic"]["size"] / 1024)>200){//200kb
		echo "文件太大了";exit;
	}
	
	//获取文件后缀
	$_arr = explode(".",$_FILES["litpic"]["name"]);
	$subfix = $_arr[1];
	
	$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	$dir = "/uploads/draft/".date("Ymd",time());
	$filename = "/".rand(10,99).time().rand(100,999).".".$subfix;
	$path = $root.$dir.$filename;
	$litpic = $dir.$filename;
	
	//创建文件夹
	make_dir($root.$dir);
	
	//保存图片
	move_uploaded_file($_FILES["litpic"]["tmp_name"],$path);
	
	//保存图片信息
	$imginfos = getimagesize($path);
	$inquery = "
	INSERT INTO #@__uploads(title,url,mediatype,width,height,playtime,filesize,uptime,mid) VALUES
	('{$litpic}','$litpic','1','".$imginfos[0]."','".$imginfos[1]."','0','".filesize($path)."','".time()."','$dimei_uid');";
	$dsql->ExecuteNoneQuery($inquery);
	$fid = $dsql->GetLastID();
}

/**
 * 循环创建目录
 * echo make_dir(ROOTPATH."/text/text1/text2");
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
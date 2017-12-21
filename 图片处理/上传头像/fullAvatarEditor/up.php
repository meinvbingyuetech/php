<?php

$result = array();
$result['success'] = false;
$success_num = 0;
$msg = '';

// 处理头像图片开始------------------------------------------------------------------------>
//头像图片(file 域的名称：__avatar1,2,3...)。

$avatars = array("__avatar1", "__avatar2", "__avatar3");
$avatars_length = count($avatars);
for ( $i = 0; $i < $avatars_length; $i++ )
{ 
	$avatar = $_FILES[$avatars[$i]];
	$avatar_number = $i + 1;
	if ( $avatar['error'] > 0 )
	{
		$msg .= $avatar['error'];
	}
	else
	{   
		if($avatar_number==1){
			$size = 'big';
		}
		else if($avatar_number==2){
			$size = 'middle';
		}
		else if($avatar_number==3){
			$size = 'small';
		}
		
		//$savePath = file_get_contents("http://www.gunshuibbs.com/app/face.php?_action=getFacePath&uid=".$uid."&size=".$size);
		//$result['avatarUrls'][$i] = toVirtualPath($savePath);
		$arr = get_face_path($user_id,$size);
		make_dir($arr['dir']);
		move_uploaded_file($avatar["tmp_name"], $arr['path']);
		$success_num++;
	}
}

$result['msg'] = $msg;
if ($success_num > 0)
{
	$result['success'] = true;
	$db->query("UPDATE " . $ecs->table('users') . " SET `face_url`='1' WHERE `user_id`=".$user_id);
}
//返回图片的保存结果（返回内容为json字符串）
print json_encode($result);

/*************************************************************************************************************/
/**
 * 获取用户的头像信息(存储文件夹，存储路径，访问路径)
 * @param int $mid      用户ID
 * @param string $size  头像尺寸（big，small，middle）
 * @param string $subfix  后缀（jpg，png）
 */
function getFacePath($mid,$size,$subfix='jpg'){
	$folder = floor($mid/1000);
	
	$dir = C('PUBLIC_PATH')."/uploads/avatar/".$folder."/".$mid;
	$path = $dir."/".$size.".".$subfix;
	$link = "/Public/uploads/avatar/".$folder."/".$mid."/".$size.".".$subfix;
	return array(
		"dir"=>$dir,
		"path"=>$path,
		"link"=>$link,
	);
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
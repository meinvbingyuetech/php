<?php
/**
* 生成高质量的缩略图函数
*
* @param 原图片地址 $img_tempname
* @param 缩略图最大宽度 $max_width
* @param 生成缩略图地址 $dst_url
* @return unknown
*/
function createDstImage($img_tempname, $max_width, $dst_url) {
	global $uploadpath, $id, $uploadtype;

	if (!file_exists($img_tempname)) {
		die('抱歉，您要上传的图片不存在!');
	}
	$img_src = file_get_contents($img_tempname);
	$image = imagecreatefromstring($img_src); //用该方法获得图象,可以避免“图片格式”的问题
	$width = imagesx($image); //取得图像宽度
	$height = imagesy($image); //取得图像高度
	$x_ratio = $max_width / $width; //宽度的比例

	if ($width <= $max_width) {
		$tn_width = $width;
		$tn_height = $height;
	} else {
		$tn_width = $max_width;
		//$tn_height=round($x_ratio*$height);
		echo $tn_height = 90;
	}

	if (function_exists('imagecreatetruecolor') && (function_exists('imagecopyresampled'))) {
		/*生成高质量的缩略图方法*/
		$dst = imagecreatetruecolor($tn_width, $tn_height); //新建一个真彩色图象
		imagecopyresampled($dst, $image, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height); //重采样拷贝部分图像并调整大小
	} else {
		$dst = imagecreate($tn_width, $tn_height);
		imagecopyresized($dst, $image, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);
	}

	imagejpeg($dst, $dst_url, 100); //以JPEG格式将图像输出到浏览器或文件,100(最佳质量,文件最大)。默认为IJG默认的质量值(大约75)
	imagedestroy($image);
	imagedestroy($dst);

	if (!file_exists($dst_url)) {
		return false;
	} else {
		return basename($dst_url);
	}
}
?>
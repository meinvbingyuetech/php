<?php
if(isset($_POST['submit'])){

define("dir", "upload/"); //存储的目录文件
if (is_uploaded_file($_FILES['file_image']['tmp_name'])) {
	$image_type = $_FILES['file_image']['type'];
	if ($image_type != "image/pjpeg") {
		echo "不支持这种格式";
	} else {
		$name = $_POST['name'];
		$result2 = move_uploaded_file($_FILES['file_image']['tmp_name'], dir . date("his", time()) . "." . fileext($_FILES['file_image']['name']));
		cutphoto(dir . date("his", time()) . ".jpg", dir . date("his", time()) . "_thumb.jpg", 256, 192); // 图片的宽,高
		unlink(dir . date("his", time()) . ".jpg");
		if ($result2 == 1)
			echo "sucessful";
		else
			echo "fuck";
	}
}

}
//获取文件后缀名函数
function fileext($filename) {
	return substr(strrchr($filename, '.'), 1);
}

//生成缩略图函数
function cutphoto($o_photo, $d_photo, $width, $height) {

	$temp_img = imagecreatefromjpeg($o_photo);
	$o_width = imagesx($temp_img); //取得原图宽
	$o_height = imagesy($temp_img); //取得原图高

	//判断处理方法
	if ($width > $o_width || $height > $o_height) { //原图宽或高比规定的尺寸小,进行压缩

		$newwidth = $o_width;
		$newheight = $o_height;

		if ($o_width > $width) {
			$newwidth = $width;
			$newheight = $o_height * $width / $o_width;
		}

		if ($newheight > $height) {
			$newwidth = $newwidth * $height / $newheight;
			$newheight = $height;
		}

		//缩略图片
		$new_img = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($new_img, $temp_img, 0, 0, 0, 0, $newwidth, $newheight, $o_width, $o_height);
		imagejpeg($new_img, $d_photo);
		imagedestroy($new_img);

	} else { //原图宽与高都比规定尺寸大,进行压缩后裁剪

		if ($o_height * $width / $o_width > $height) { //先确定width与规定相同,如果height比规定大,则ok
			$newwidth = $width;
			$newheight = $o_height * $width / $o_width;
			$x = 0;
			$y = ($newheight - $height) / 2;
		} else { //否则确定height与规定相同,width自适应
			$newwidth = $o_width * $height / $o_height;
			$newheight = $height;
			$x = ($newwidth - $width) / 2;
			$y = 0;
		}

		//缩略图片
		$new_img = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($new_img, $temp_img, 0, 0, 0, 0, $newwidth, $newheight, $o_width, $o_height);
		imagejpeg($new_img, $d_photo);
		imagedestroy($new_img);

		$temp_img = imagecreatefromjpeg($d_photo);
		$o_width = imagesx($temp_img); //取得缩略图宽
		$o_height = imagesy($temp_img); //取得缩略图高

		//裁剪图片
		$new_imgx = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_imgx, $temp_img, 0, 0, $x, $y, $width, $height, $width, $height);
		imagejpeg($new_imgx, $d_photo);
		imagedestroy($new_imgx);
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>上传文件页面</title>
</head>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
<br/>上传文件<input type="file" name ="file_image" value="" />
<input type="submit" value="确认上传" name ="submit" />
</form>
</body>
</html>
<?php
/*
 * 先获取文件大小 $fs = filesize($filename);
 * $is_mb 该参数表明，你要获取的是KB数(0) 还是 MB数(1)
 * 返回 e.g：0.3 然后字母自己写，这样比较有扩展性
 * $fs = filesize("ceHDjXDlrPe3M.jpg");
 * echo GetFileSize($fs,1);
 */
function GetFileSize($fs,$is_mb)
{
	if($is_mb==0){
		$fs = $fs/1024;
	}else{
		$fs = $fs/1024/1024;
	}
	return sprintf("%10.1f",$fs);
}

function get_extension($file)
{
	return pathinfo($file, PATHINFO_EXTENSION);
}

function get_extension($file)
{
	return substr(strrchr($file, '.'), 1);
}

///
$temp_arr = explode(".", $file_name);
$file_ext = array_pop($temp_arr);
$file_ext = trim($file_ext);
$file_ext = strtolower($file_ext);

/**
 * 获取文件后缀名,并判断是否合法
 *
 * @param string $file_name
 * @param array $allow_type
 * @return blob
 */
function get_file_suffix($file_name, $allow_type = array())
{
    $file_suffix = strtolower(array_pop(explode('.', $file_name)));
    if (empty($allow_type))
    {
        return $file_suffix;
    }
    else
    {
        if (in_array($file_suffix, $allow_type))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
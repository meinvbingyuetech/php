<?php

$array = array(
	array("title"=>"百度","link"=>"http://www.baidu.com/"),
	array("title"=>"谷歌","link"=>"http://www.google.com/"),
);

$str='<?php $array=' . var_export($array,true) . '; ?>';
echo file_put_contents('arr.txt', $str,LOCK_EX);


/**
 * 读结果缓存文件
 *
 * @params  string  $cache_name
 *
 * @return  array   $data
 */
function read_static_cache($cache_name)
{
    static $result = array();
    if (!empty($result[$cache_name]))
    {
        return $result[$cache_name];
    }
    $cache_file_path = ROOT_PATH . '/temp/static_caches/' . $cache_name . '.php';
    if (file_exists($cache_file_path))
    {
        include_once($cache_file_path);
        $result[$cache_name] = $data;
        return $result[$cache_name];
    }
    else
    {
        return false;
    }
}

/**
 * 写结果缓存文件
 *
 * @params  string  $cache_name
 * @params  array   $caches
 *
 * @return
 */
function write_static_cache($cache_name, $caches)
{
    $cache_file_path = ROOT_PATH . '/temp/static_caches/' . $cache_name . '.php';
    $content = "<?php\r\n";
    $content .= "\$data = " . var_export($caches, true) . ";\r\n";
    $content .= "?>";
    file_put_contents($cache_file_path, $content, LOCK_EX);
}
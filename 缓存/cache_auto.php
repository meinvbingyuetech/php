<?php
/**
 * auto_cache.php 实现智能的自动缓存。
 * 使用办法极其简单：
 * 在需要实现缓存功能的页面 require 'auto_cache.php'; 就ok了
 * @author rains31@gmail.com
 */

//存放缓存的根目录,最好是放到/tmp目录,尤其是虚拟主机用户,因为/tmp目录不占自己的主页空间啊:)

define('CACHE_ROOT', dirname(dirname(__FILE__)) . '/scache');

//缓存文件的生命期，单位秒，86400秒是一天

define('CACHE_LIFE', 86400);

//缓存文件的扩展名，千万别用 .php .asp .jsp .pl 等等

define('CACHE_SUFFIX', '.cache');

//缓存文件名

$file_name = md5($_SERVER['REQUEST_URI']) . CACHE_SUFFIX;

//缓存目录，根据md5的前两位把缓存文件分散开。避免文件过多。如果有必要，可以用第三四位为名，再加一层目录。

//256个目录每个目录1000个文件的话，就是25万个页面。两层目录的话就是65536*1000=六千五百万。

//不要让单个目录多于1000，以免影响性能。

$cache_dir = CACHE_ROOT . '/' . substr($file_name, 0, 3) . '/' . substr($file_name, 3, 3);

//缓存文件

$cache_file = $cache_dir . '/' . $file_name;

//GET方式请求才缓存，POST之后一般都希望看到最新的结果

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	//如果缓存文件存在，并且没有过期，就把它读出来。

	if (file_exists($cache_file) && time() - filemtime($cache_file) < CACHE_LIFE) {

		$fp = fopen($cache_file, 'rb');

		fpassthru($fp);

		fclose($fp);

		exit;

	}

	elseif (!file_exists($cache_dir)) {

		if (!file_exists(CACHE_ROOT)) {

			mkdir(CACHE_ROOT, 0777);

			chmod(CACHE_ROOT, 0777);

		}

		mkdir($cache_dir, 0777);

		chmod($cache_dir, 0777);

	}

	//回调函数，当程序结束时自动调用此函数

	function auto_cache($contents) {

		global $cache_file;

		$fp = fopen($cache_file, 'wb');

		fwrite($fp, $contents);

		fclose($fp);

		chmod($cache_file, 0777);

		//生成新缓存的同时，自动删除所有的老缓存。以节约空间。

		clean_old_cache();

		return $contents;

	}

	function clean_old_cache() {

		chdir(CACHE_ROOT);

		foreach (glob("*/*" . CACHE_SUFFIX) as $file) {

			if (time() - filemtime($file) > CACHE_LIFE) {

				unlink($file);

			}

		}

	}

	//回调函数 auto_cache

	ob_start('auto_cache');

} else {

	//不是GET的请求就删除缓存文件。

	if (file_exists($cache_file))
		unlink($cache_file);

}
?>
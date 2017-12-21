<?php

/**
 * 获取远程网页的编码
 * e.g:
 * $str = "http://www.163.com";
 * $htmlsoruct = file_get_contents($str);
 * echo get_pageCode($htmlsoruct);
 */
function get_pageCode($htmlsoruct) {

	preg_match_all("/<meta[^>]+(http\-equiv|name|content)=\"([^\"]*)\"[^>]" . "+(http\-equiv|name|content)=\"([^\"]*)\"[^>]*>/i", $htmlsoruct, $split_html);

	$tag_arr = array ();
	foreach ($split_html[0] as $key => $tag_str) {
		if (in_array($split_html[1][$key], array (
				'http-equiv',
				'name'
			))) {
			$tag_arr[strtolower($split_html[2][$key])] = $split_html[4][$key];
		} else {
			$tag_arr[strtolower($split_html[4][$key])] = $split_html[2][$key];
		}
	}

	if (!$tag_arr['content-type']) {
		//echo 1;
		$html_head = substr($html, 0, strpos($html, '</head>'));
		preg_match_all("/<meta charset=[\"|\']?([a-zA-Z0-9\-\_]+)[\"|\']?/i", $html_head, $page_code_arr);
	} else {
		//echo 2;
		preg_match_all("/charset=(.*)/i", $tag_arr['content-type'], $page_code_arr);
	}
	return $page_code = strtolower($page_code_arr[1][0]);

}
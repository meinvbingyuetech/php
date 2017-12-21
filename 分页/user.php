<?php

/**
  * 获取分页的HTML内容
  * @param integer $page 当前页
  * @param integer $pages 总页数
  * @param string $url 跳转url地址    最后的页数以 '&page=x' 追加在url后面
  *
  * @return string HTML内容;
  */
function getPageHtml($page, $pages, $url){
	//最多显示多少个页码
	$_pageNum = 5;
	//当前页面小于1 则为1
	$page = $page<1?1:$page;
	//当前页大于总页数 则为总页数
	$page = $page > $pages ? $pages : $page;
	//页数小当前页 则为当前页
	$pages = $pages < $page ? $page : $pages;

	//计算开始页
	$_start = $page - floor($_pageNum/2);
	$_start = $_start<1 ? 1 : $_start;
	//计算结束页
	$_end = $page + floor($_pageNum/2);
	$_end = $_end>$pages? $pages : $_end;

	//当前显示的页码个数不够最大页码数，在进行左右调整
	$_curPageNum = $_end-$_start+1;
	//左调整
	if($_curPageNum<$_pageNum && $_start>1){ 
		$_start = $_start - ($_pageNum-$_curPageNum);
		$_start = $_start<1 ? 1 : $_start;
		$_curPageNum = $_end-$_start+1;
	}
	//右边调整
	if($_curPageNum<$_pageNum && $_end<$pages){
		$_end = $_end + ($_pageNum-$_curPageNum);
		$_end = $_end>$pages? $pages : $_end;
	}

	$_pageHtml = '<div class="bigPage clearfix" id="pagelist">';
	if($page>1 && $page<=$pages){
		$_pageHtml .= '<a href="'.page_uri_parse($url,1).'" style=" border-left:1px solid #ccc;margin-right: -5px;"> 首页 </a> ';
	}
	if($page>1 && $page<=$pages){
		$_pageHtml .= '<a class="pagePrev" href="'.page_uri_parse($url,$page-1).'"><b>上一页</b></a>';
	}
	for ($i = $_start; $i <= $_end; $i++) {
		if($i == $page){
			$_pageHtml .= '<a href="javascript:;" class="selected">'.$i.'</a>';
		}else{
			$_pageHtml .= '<a href="'.page_uri_parse($url,$i).'">'.$i.'</a>';
		}
	}
	
	if($page>=1 && $page<$pages){
		$_pageHtml .= '<a href="'.page_uri_parse($url,$page+1).'" class="pageNext"><b>下一页</b></a>';
	}
	if($page>=1 && $page<$pages){
		$_pageHtml .= '<a href="'.page_uri_parse($url,$pages).'">尾页</a>';
	}
	$_pageHtml .= '</div>';

	return $_pageHtml;
}

function page_uri_parse($url,$page){
	return str_replace("{page}",$page,$url);
}
?>
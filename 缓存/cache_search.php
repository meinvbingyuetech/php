<?php
include_once (dirname(__FILE__)."/plus/cache.php");
include_once (dirname(__FILE__)."/scache/filecache.php");
include_once (dirname(__FILE__)."/include/config_base.php");
include_once (dirname(__FILE__)."/include/inc_functions.php");
include_once (dirname(__FILE__)."/plus/page.php");

//转换状态值
if($finished==1){$finished = '连载中';}
if($finished==2){$finished = '已完结';}
if($finished==3){$finished = '新番预告';}

//未定义的情况下默认为0
if(!isset($finished)){$finished = '0';}
if(!isset($subject)){$subject = '0';}
if(!isset($content)){$content = '0';}
if(!isset($year)){$year = '0';}
if(!isset($letter)){$letter = '0';}
if(!isset($sex)){$sex = '0';}
if(!isset($lang)){$lang = '0';}

$temp_final_arr = array();
$page_nums = 0;//分页数据总记录数
$page_sub=5;//每次显示的页数
$page_size = 20;//每页显示的条数
if (isset ($_GET['page'])) {//起始页
    $curNum = $_GET['page'];
} else {
    $curNum = 1;
}
$beginPage = ($curNum -1) * $page_size;//起始下标

$shiji = 0;//实际符合参数
$total = 0;//总共传值参数

if(strlen($subject)>0){$total++;}
if(strlen($finished)>0){$total++;}
if(strlen($content)>0){$total++;}
if(strlen($year)>0){$total++;}
if(strlen($letter)>0){$total++;}
if(strlen($sex)>0){$total++;}
if(strlen($lang)>0){$total++;}

for($i=0;$i<count($manhua);$i++){

    //如果该项值为0，即为全部，则不管值为什么都选中;如果为具体值再来匹配
    if($subject=='0'){$shiji++;}else if($subject==$manhua[$i]['subject']){$shiji++;}
    if($finished=='0'){$shiji++;}else if($finished==$manhua[$i]['status']){$shiji++;}
    if($content=='0'){$shiji++;}else if(strpos($manhua[$i]['content'],$content)>-1){$shiji++;}
    if($year=='0'){$shiji++;}else if($year==$manhua[$i]['year']){$shiji++;}
    if($letter=='0'){$shiji++;}else if($letter==$manhua[$i]['letter']){$shiji++;}
    if($sex=='0'){$shiji++;}else if($sex==$manhua[$i]['sex']){$shiji++;}
    if($lang=='0'){$shiji++;}else if($lang==$manhua[$i]['lang']){$shiji++;}

    if($total==$shiji){
        $page_nums++;
        $a = array( 'title' => ''.$manhua[$i]['title'].'',
            'litpic' => ''.$manhua[$i]['litpic'].'',
            'writer' => ''.$manhua[$i]['writer'].'',
            'status' => ''.$manhua[$i]['status'].'',
			'total_count' => ''.$manhua[$i]['total_count'].'',
            'new_hua_title' => ''.$manhua[$i]['new_hua_title'].''
        );
        array_unshift($temp_final_arr,$a);
    }

    $shiji = 0;//重置参数
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>搜索动漫</title>
<link rel="stylesheet" type="text/css" href="css/stylev2.css"/>
<link rel="stylesheet" type="text/css" href="/img/page2.css"/>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/search-ui.js"></script>
<script type="text/javascript" src="http://cbjs.baidu.com/js/m.js"></script>
</head>
<body>
<div  class="wrap">
  <?php
  $content_head = file_get_contents("index.shtml");
  //$content_head = preg_replace("/[\n| ]{2,}/", "", $content_head);
  $content_head = preg_replace("'([\r\n])[\s]+'", "", $content_head);
  preg_match_all("/<div class=\"wrap\">(.*?)<div class=\"w250 border-hui l mr8\">/isU", $content_head, $m);
  //echo str_replace("<div class=\"hr10\"></div>","",$m[1][0]);
  echo $m[1][0];
  ?>
  <div class="add both">当前位置：<a href="http://www.kan300.com/">看撒动漫网</a> > 漫画搜索</div>
  <div class="hr10"></div>
  <div class="border-main bg-white l">
    <div id="search_item" class="search-item p10 l">
      <h2>搜索动漫</h2>
      <dl>
        <dt>按内容：</dt>
        <dd id="search_item_3">
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=0&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='0'){echo "class='this'";}?>>全部</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=1_1&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='1_1'){echo "class='this'";}?>>动作</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=1_2&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='1_2'){echo "class='this'";}?>>机战</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=1_3&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='1_3'){echo "class='this'";}?>>战争</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=1_4&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='1_4'){echo "class='this'";}?>>历史</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=1_5&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='1_5'){echo "class='this'";}?>>神魔</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=1_6&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='1_6'){echo "class='this'";}?>>推理</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=1_7&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='1_7'){echo "class='this'";}?>>悬疑</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=1_8&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='1_8'){echo "class='this'";}?>>冒险</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=1_9&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='1_9'){echo "class='this'";}?>>剑客</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=10&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='10'){echo "class='this'";}?>>忍者</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=11&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='11'){echo "class='this'";}?>>体育</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=12&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='12'){echo "class='this'";}?>>搞笑</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=13&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='13'){echo "class='this'";}?>>赛车</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=14&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='14'){echo "class='this'";}?>>耽美</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=15&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='15'){echo "class='this'";}?>>百合</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=16&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='16'){echo "class='this'";}?>>宠物</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=17&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='17'){echo "class='this'";}?>>萝莉</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=18&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='18'){echo "class='this'";}?>>恋爱</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=19&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='19'){echo "class='this'";}?>>后宫</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=20&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($content=='20'){echo "class='this'";}?>>肉片</a>
        </dd>
      </dl>
      <dl>
        <dt>按播出：</dt>
        <dd>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=0&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($subject=='0'){echo "class='this'";}?>>全部</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=1&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($subject=='1'){echo "class='this'";}?>>TV动画</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=2&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($subject=='2'){echo "class='this'";}?>>OVA动画</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=3&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($subject=='3'){echo "class='this'";}?>>剧场版</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=4&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($subject=='4'){echo "class='this'";}?>>特别篇</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=5&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($subject=='5'){echo "class='this'";}?>>番外篇</a>
        </dd>
      </dl>
      <dl>
        <dt>按性别：</dt>
        <dd>
        <a href="search.php?sex=0&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($sex=='0'){echo "class='this'";}?>>全部</a>
        <a href="search.php?sex=1&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($sex=='1'){echo "class='this'";}?>>男生</a>
        <a href="search.php?sex=2&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($sex=='2'){echo "class='this'";}?>>女生</a>
        <a href="search.php?sex=3&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($sex=='3'){echo "class='this'";}?>>中性</a>
        </dd>
      </dl>
      <dl>
        <dt>按进度：</dt>
        <dd>
        <a href="search.php?subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=0" <?php if($finished=='0'){echo "class='this'";}?>>全部</a>
        <a href="search.php?subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=1" <?php if($finished=='连载中'){echo "class='this'";}?>>连载中</a>
        <a href="search.php?subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=2" <?php if($finished=='已完结'){echo "class='this'";}?>>已完结</a>
        <a href="search.php?subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=<?php echo $letter?>&amp;finished=3" <?php if($finished=='新番预告'){echo "class='this'";}?>>新番预告</a>
        </dd>
      </dl>
      <dl>
        <dt>按语言：</dt>
        <dd>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=0&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($lang=='0'){echo "class='this'";}?>>全部</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=1&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($lang=='1'){echo "class='this'";}?>>日语</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=2&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($lang=='2'){echo "class='this'";}?>>国语</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=3&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($lang=='3'){echo "class='this'";}?>>粤语</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=4&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($lang=='4'){echo "class='this'";}?>>英语</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=5&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content;?>&amp;year=<?php echo $year;?>&amp;letter=<?php echo $letter;?>&amp;finished=<?php echo $finished;?>" <?php if($lang=='5'){echo "class='this'";}?>>其他</a>
        </dd>
      </dl>
      <dl>
        <dt>按年份：</dt>
        <dd>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=0&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='0'){echo "class='this'";}?>>全部</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2010&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2010'){echo "class='this'";}?>>2010</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2009&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2009'){echo "class='this'";}?>>2009</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2008&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2008'){echo "class='this'";}?>>2008</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2007&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2007'){echo "class='this'";}?>>2007</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2006&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2006'){echo "class='this'";}?>>2006</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2005&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2005'){echo "class='this'";}?>>2005</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2004&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2004'){echo "class='this'";}?>>2004</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2003&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2003'){echo "class='this'";}?>>2003</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2002&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2002'){echo "class='this'";}?>>2002</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2001&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2001'){echo "class='this'";}?>>2001</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=2000&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='2000'){echo "class='this'";}?>>2000</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=1&amp;letter=<?php echo $letter?>&amp;finished=<?php echo $finished?>" <?php if($year=='1'){echo "class='this'";}?>>2000之前</a>
        </dd>
      </dl>
      <dl>
        <dt>按字母：</dt>
        <dd>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=0&amp;finished=<?php echo $finished?>" <?php if($letter=='0'){echo "class='this'";}?>>全部</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=1&amp;finished=<?php echo $finished?>" <?php if($letter=='1'){echo "class='this'";}?>>数字</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=a&amp;finished=<?php echo $finished?>" <?php if($letter=='a'){echo "class='this'";}?>>A</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=b&amp;finished=<?php echo $finished?>" <?php if($letter=='b'){echo "class='this'";}?>>B</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=c&amp;finished=<?php echo $finished?>" <?php if($letter=='c'){echo "class='this'";}?>>C</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=d&amp;finished=<?php echo $finished?>" <?php if($letter=='d'){echo "class='this'";}?>>D</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=e&amp;finished=<?php echo $finished?>" <?php if($letter=='e'){echo "class='this'";}?>>E</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=f&amp;finished=<?php echo $finished?>" <?php if($letter=='f'){echo "class='this'";}?>>F</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=g&amp;finished=<?php echo $finished?>" <?php if($letter=='g'){echo "class='this'";}?>>G</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=h&amp;finished=<?php echo $finished?>" <?php if($letter=='h'){echo "class='this'";}?>>H</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=i&amp;finished=<?php echo $finished?>" <?php if($letter=='i'){echo "class='this'";}?>>I</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=j&amp;finished=<?php echo $finished?>" <?php if($letter=='j'){echo "class='this'";}?>>J</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=k&amp;finished=<?php echo $finished?>" <?php if($letter=='k'){echo "class='this'";}?>>K</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=l&amp;finished=<?php echo $finished?>" <?php if($letter=='l'){echo "class='this'";}?>>L</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=m&amp;finished=<?php echo $finished?>" <?php if($letter=='m'){echo "class='this'";}?>>M</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=n&amp;finished=<?php echo $finished?>" <?php if($letter=='n'){echo "class='this'";}?>>N</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=o&amp;finished=<?php echo $finished?>" <?php if($letter=='o'){echo "class='this'";}?>>O</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=p&amp;finished=<?php echo $finished?>" <?php if($letter=='p'){echo "class='this'";}?>>P</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=q&amp;finished=<?php echo $finished?>" <?php if($letter=='q'){echo "class='this'";}?>>Q</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=r&amp;finished=<?php echo $finished?>" <?php if($letter=='r'){echo "class='this'";}?>>R</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=s&amp;finished=<?php echo $finished?>" <?php if($letter=='s'){echo "class='this'";}?>>S</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=t&amp;finished=<?php echo $finished?>" <?php if($letter=='t'){echo "class='this'";}?>>T</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=u&amp;finished=<?php echo $finished?>" <?php if($letter=='u'){echo "class='this'";}?>>U</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=v&amp;finished=<?php echo $finished?>" <?php if($letter=='v'){echo "class='this'";}?>>V</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=w&amp;finished=<?php echo $finished?>" <?php if($letter=='w'){echo "class='this'";}?>>W</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=x&amp;finished=<?php echo $finished?>" <?php if($letter=='x'){echo "class='this'";}?>>X</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=y&amp;finished=<?php echo $finished?>" <?php if($letter=='y'){echo "class='this'";}?>>Y</a>
        <a href="search.php?sex=<?php echo $sex?>&amp;lang=<?php echo $lang?>&amp;subject=<?php echo $subject?>&amp;content=<?php echo $content?>&amp;year=<?php echo $year?>&amp;letter=x&amp;finished=<?php echo $finished?>" <?php if($letter=='z'){echo "class='this'";}?>>Z</a>
        </dd>
      </dl>
    </div>
    <div class="hr-bg"></div>
    <div id="search_btn" class="search-hide-item">收起标签</div>
     <div id="search_list" class="anime-list">
      <ul>
      <?php
        $temp_final_str .= '';
        $temp_final_num = 0;
        //print_r($temp_final_arr);
        for($y=0;$y<count($temp_final_arr);$y++){
            if($temp_final_num<$page_size){
                if($y>=$beginPage && $y<=($page_size+$beginPage)){
                    if(strpos($temp_final_arr[$y]['litpic'],"http")>-1){
                        $litpic = $temp_final_arr[$y]['litpic'];
                    }else{
                        $litpic = "http://www.kan300.com".$temp_final_arr[$y]['litpic'];
                    }
					if($temp_final_arr[$y]['status']=='已完结'){
						$gengxinzhi = $temp_final_arr[$y]['total_count']."集全";
					}else{
						$gengxinzhi = "更新至".$temp_final_arr[$y]['new_hua_title'];
					}
                    $temp_final_str.= "<li>
                              <div class=\"list-picname\"><a href=\"/dm/".GetPinyin_mh($temp_final_arr[$y]['title'])."\" target='_blank'><img src='".$litpic."' width='120' height='168' border='0' /><font></font></a></div>
                    <h4><a href='/dm/".GetPinyin_mh($temp_final_arr[$y]['title'])."' target='_blank'>".$temp_final_arr[$y]['title']."</a></h4>
                    <em>".$gengxinzhi."</em>
                    <div class='list-btns'><span class='btns l btn-play'><a href='/dm/".GetPinyin_mh($temp_final_arr[$y]['title'])."/".$temp_final_arr[$y]['new_hua_id'].".shtml'>播放</a></span>
                    <span class='btns r btn-infos'><a href='/dm/".GetPinyin_mh($temp_final_arr[$y]['title'])."'>详细</a></span></div>
                    </li>";
                    $temp_final_num++;
                }
            }
        }
        echo $temp_final_str;
        ?>
      </ul>
    </div>
    <div class="hr10"></div>
    <div class="page">
      <?php
        if(count($temp_final_arr)>0){
            $page = new PageClass($page_nums,$page_size,$_GET['page'],'?page={page}');//用于动态
            echo $page -> myde_write();//显示
        }
      ?>
    </div>
    <div class="hr20"></div>
  </div>
</div>
</body>
</html>
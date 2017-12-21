<?php
include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/include/common.inc.php';
include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/uc_client/client.php';
include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/data/config.product.php';

header("Content-type: text/xml");
$str='<?xml version="1.0" encoding="UTF-8" ?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

/*$arrNew = get_arcList('',10000,'','','','','','','','','','','','');
foreach($arrNew as $data){

	$str.='<url><loc>'.$cfg_basehost.$data['link'].'</loc><lastmod>'.$data['pubdate'].'</lastmod><changefreq>daily</changefreq><priority>'.$data['weight'].'</priority></url>';
}*/

//首页
$str .= '<url><loc>'.$cfg_basehost.'/</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>1</priority></url>';

//品牌
$str .= '<url><loc>'.$cfg_basehost.'/M-Brand-line6.html</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
$str .= '<url><loc>'.$cfg_basehost.'/M-Brand-LIVID.html</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
$str .= '<url><loc>'.$cfg_basehost.'/M-Brand-MIDI.html</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
$str .= '<url><loc>'.$cfg_basehost.'/M-Brand-Audient.html</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
$str .= '<url><loc>'.$cfg_basehost.'/M-Brand-SAMSON.html</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
$str .= '<url><loc>'.$cfg_basehost.'/M-Brand-Arturia.html</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
$str .= '<url><loc>'.$cfg_basehost.'/M-Brand-JetCity333.html</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
$str .= '<url><loc>'.$cfg_basehost.'/M-Brand-Hartke.html</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';

//关于我们
$str .= '<url><loc>'.$cfg_basehost.'/about.html</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';


//顶级栏目
$arrAll = getCatalogList('and id in(1,2,23,7,44)','id desc','0,10');
foreach($arrAll as $k=>$v){
    //$str .= '<a href="'.$cfg_basehost.$v['typelink'].'">链接</a>';
    $str .= '<url><loc>'.$cfg_basehost.$v['typelink'].'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
    //$str .= '<br>';

    if($v['id']==7){//知道，退出
        continue;
    }

    $str_catIds = getSonCatalogIDs($v[id]);
    $arrListAll = getDocListTotal('and typeid in ('.$str_catIds.')',20);
    for($i=1;$i<=$arrListAll['totalPage'];$i++){
        if($v['id']==44){//秀场
            continue;
            $url = $cfg_basehost.$v['typelink'].'all/p'.$i.'.html';
        }
        else{
            $url = $cfg_basehost.$v['typelink'].'p'.$i.'.html';
        }
        //$str .= '<a href="'.$url.'">链接</a>';
        $str .= '<url><loc>'.$url.'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url>';
        //$str .= '<br>';
    }
}

//课堂-贴士
$str .= '<url><loc>'.$cfg_basehost.'/ke/msjs/pipi/</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url>';
$str .= '<url><loc>'.$cfg_basehost.'/ke/tips/</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url>';

//新闻资讯-子栏目
$arr_catIds_news = getSonCatalogIDs(1,'array');
foreach($arr_catIds_news as $kSon=>$vSon){
    $info = formatCatalogInfo(getCatalogInfo(" and id=".$vSon['id']));
    $arrListAll = getDocListTotal('and typeid='.$info['id'],20);
    for($i=1;$i<=$arrListAll['totalPage'];$i++){
        $url = $cfg_basehost.$info['typelink'].'p'.$i.'.html';
        if($i==1){
            //$str .= '<a href="'.$url.'">链接</a>';
            $str .= '<url><loc>'.str_replace("p1.html","",$url).'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.7</priority></url>';
            //$str .= '<br>';
        }
        //$str .= '<a href="'.$url.'">链接</a>';
        $str .= '<url><loc>'.$url.'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.7</priority></url>';
        //$str .= '<br>';
    }
}

//硬件评测-子栏目
foreach($product as $k=>$v){
    if($v[id]!=0 || $v[id]!=7){
        $arrListAll = getDocListTotal(' and class=4 and product='.$v['id'],20);
        if($arrListAll[totalNums]>0){
            for($i=1;$i<=$arrListAll['totalPage'];$i++){

                $url = $cfg_basehost.'/pingce/'.$v['dir'].'/p'.$i.'.html';
                if($i==1){
                    //$str .= '<a href="'.$url.'">链接</a>';
                    $str .= '<url><loc>'.str_replace("p1.html","",$url).'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.7</priority></url>';
                    //$str .= '<br>';
                }
                //$str .= '<a href="'.$url.'">链接</a>';
                $str .= '<url><loc>'.$url.'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.7</priority></url>';
                //$str .= '<br>';
            }
        }
    }
}

//硬件讲台-子栏目
foreach($product as $k=>$v){
    if($v[id]!=0 || $v[id]!=7){
        $arrListAll = getDocListTotal(' and class=2 and product='.$v['id'],20);
        if($arrListAll[totalNums]>0){
            for($i=1;$i<=$arrListAll['totalPage'];$i++){

                $url = $cfg_basehost.'/classroom/'.$v['dir'].'/p'.$i.'.html';
                if($i==1){
                    //$str .= '<a href="'.$url.'">链接</a>';
                    $str .= '<url><loc>'.str_replace("p1.html","",$url).'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.7</priority></url>';
                    //$str .= '<br>';
                }
                //$str .= '<a href="'.$url.'">链接</a>';
                $str .= '<url><loc>'.$url.'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.7</priority></url>';
                //$str .= '<br>';
            }
        }
    }
}

//秀场-子栏目
/*$arr_catIds_show = getSonCatalogIDs(44,'array');
foreach($arr_catIds_show as $kSon=>$vSon){
    $info = formatCatalogInfo(getCatalogInfo(" and id=".$vSon['id']));
    $arrListAll = getDocListTotal('and typeid='.$info['id'],20);
    for($i=1;$i<=$arrListAll['totalPage'];$i++){
        $url = $cfg_basehost.$info['typelink'].'p'.$i.'.html';
        if($i==1){
            //$str .= '<a href="'.$url.'">链接</a>';
            $str .= '<url><loc>'.str_replace("p1.html","",$url).'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.7</priority></url>';
            //$str .= '<br>';
        }
        //$str .= '<a href="'.$url.'">链接</a>';
        $str .= '<url><loc>'.$url.'</loc><lastmod>'.date("Y-m-d",time()).'T'.date("H:i:s",time()).'</lastmod><changefreq>daily</changefreq><priority>0.7</priority></url>';
        //$str .= '<br>';
    }
}*/

//内容页
$row = getDocList('and class not in(5)',' pubdate desc');
foreach($row as $k=>$v){
    $url = $cfg_basehost.$v['arclink'];
    if(strstr($url,'/ask/')){
        continue;
    }
    //$str .= '<a href="'.$url.'">链接</a>';
    $str .= '<url><loc>'.$url.'</loc><lastmod>'.$v[pubdate].'</lastmod><changefreq>daily</changefreq><priority>0.6</priority></url>';
    //$str .= '<br>';
}

//知道内容页
$row = getAskList('and arcrank=1 and aid=0','ctime desc');
foreach($row as $k=>$v){
    $url = $cfg_basehost.$v['arclink'];
    //$str .= '<a href="'.$url.'">链接</a>';
    $str .= '<url><loc>'.$url.'</loc><lastmod>'.$v[date].'</lastmod><changefreq>daily</changefreq><priority>0.6</priority></url>';
    //$str .= '<br>';
}

//print_r($row);exit;
//echo $str;exit;

$str.='</urlset>';

echo $str;

?>
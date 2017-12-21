<?php 
// one
$cont = preg_replace('/<a\s([\s\S]*?)>([\s\S]*?)<\/a>/i', "\\2", $cont);

// two
$partten = '/<a.*>(.*)<\/a>/iUm';
$cont = preg_replace($partten,'\\1',$cont);



/**
 *  删除非站内链接
 *
 * @access    public
 * @param     string  $body  内容
 * @param     array  $allow_urls  允许的超链接
 * @return    string
 */
function Replace_Links( &$body, $allow_urls=array()  )
{
    $host_rule = join('|', $allow_urls);
    $host_rule = preg_replace("#[\n\r]#", '', $host_rule);
    $host_rule = str_replace('.', "\\.", $host_rule);
    $host_rule = str_replace('/', "\\/", $host_rule);
    $arr = '';
    preg_match_all("#<a([^>]*)>(.*)<\/a>#iU", $body, $arr);
    if( is_array($arr[0]) )
    {
        $rparr = array();
        $tgarr = array();
        foreach($arr[0] as $i=>$v)
        {
            if( $host_rule != '' && preg_match('#'.$host_rule.'#i', $arr[1][$i]) )
            {
                continue;
            } else {
                $rparr[] = $v;
                $tgarr[] = $arr[2][$i];
            }
        }
        if( !empty($rparr) )
        {
            $body = str_replace($rparr, $tgarr, $body);
        }
    }
    $arr = $rparr = $tgarr = '';
    return $body;
}


?>
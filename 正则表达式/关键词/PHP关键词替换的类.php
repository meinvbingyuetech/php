php关键词替换的类(避免重复替换，保留与还原原始链接)

本节主要内容：

一个关键词替换的类

主要可以用于关键词过滤，或关键词查找替换方面。

实现过程分析：

关键词替换，其实就是一个str_replace()的过程，如果是单纯的str_replace面对10W的关键词，1W字的文章也只需要2秒左右。

问题所在：

关键词替换了不只一次，比如a需要替换成<a>a</a>，但结果可能是<a><a>a</a></a>等这样。

为此，需要一个方法保护好已经替换了的标签，那么在处理文章之前，就先把标签替换掉比如[_tnum_]在文章处理好了以后再把它还原。

另外一个问题，如果关键字或文章中有[_tnum_]本身怎么办，那么就需要排除这种这里就不能使用str_replace了而需要用到preg_replace用正则来排除。

第三个问题，如果有两个关键字a和ab怎么办，希望先把长的匹配掉，短后匹配，这样就需要在匹配前先排序。

最后一个问题，当str_replace改成了preg_replace以后，变慢了同样一段话10W次匹配要5秒钟，字符串处理的函数中strpos要快一些，那么先用strpos找出关键词即可，10W次查询还不到1秒。就算是100万才道8秒多。

<?php 
 /*  
  * 关键词匹配类 
  * @author ylx <ylx@gmail.com> 
  * @packet mipang 
  * 使用实例 
  * $str = "绿壳蛋鸡撒范德萨下一年，下一年的洒落开房间卢卡斯地方军"; 
  * $key = new KeyReplace($str,array("xxxx"=>"sadf","下一年"=>'http://baidu.com',"下一年"=>'google.com')); 
  * echo $key->getResultText(); 
  * echo $key->getRuntime(); 
  */
class KeyReplace 
{ 
 private $keys = array(); 
 private $text = ""; 
 private $runtime = ; 
 private $url = true; 
 private $stopkeys = array(); 
 private $all = false; 
 /** 
  * @access public   
  * @param string $text 指定被处理的文章 
  * @param array $keys 指定字典词组array(key=>url,...) url可以是数组，如果是数组将随机替换其中的一个 
  * @param array $stopkeys 指定停止词array(key,...) 这里面的词将不会被处理 
  * @param boolean $url true 表示替换成链接否则只替换 
  * @param boolean $all true 表示替换所有找到的词，否则只替换第一次 
  */
 public function __construct($text='',$keys=array(),$url=true,$stopkeys=array(),$all=false) { 
  $this->keys = $keys; 
  $this->text = $text; 
  $this->url = $url; 
  $this->stopkeys = $stopkeys; 
  $this->all = $all; 
 } 
 /** 
  * 获取处理好的文章 
  * @access public   
  * @return string text 
  */
 public function getResultText() { 
  $start = microtime(true); 
  $keys = $this->hits_keys(); 
  $keys_tmp = array_keys()($keys); 
  function cmp($a, $b){ 
   if (mb_strlen($a) == mb_strlen($b)) { 
 return ; 
   } 
   return (mb_strlen($a) < mb_strlen($b)) ? : -; 
  } 
  usort($keys_tmp,"cmp"); 
  foreach($keys_tmp as $key){ 
   if(is_array($keys[$key])){ 
 $url = $keys[$key][rand(,count($keys[$key])-)]; 
   }else
 $url = $keys[$key]; 
   $this->text = $this->r_s($this->text,$key,$url); 
  } 
  $this->runtime = microtime(true)-$start; 
  return $this->text; 
 } 
 /** 
  * 获取处理时间 
  * @access public   
  * @return float  
  */
 public function getRuntime() { 
  return $this->runtime; 
 } 
 /** 
  * 设置关键词 
  * @access public   
  * @param array $keys array(key=>url,...) 
  */
 public function setKeys($keys) { 
  $this->keys = $keys; 
 } 
 /** 
  * 设置停止词 
  * @access public   
  * @param array $keys array(key,...) 
  */
 public function setStopKeys($keys) { 
  $this->stopkeys = $keys; 
 } 
 /** 
  * 设置文章 
  * @access public   
  * @param string $text  
  */
 public function setText($text) { 
  $this->text = $text; 
 } 
 /** 
  * 用来找到字符串里面命中的关键词 
  * @access public 
  * @return array $keys 返回匹配到的词array(key=>url,...) 
  */
 public function hits_keys(){ 
  $ar = $this->keys; 
  $ar = $ar?$ar:array(); 
  $result=array(); 
  $str = $this->text; 
  foreach($ar as $k=>$url){ 
   $k = trim($k); 
   if(!$k) 
 continue; 
   if(strpos($str,$k)!==false && !in_array($k,$this->stopkeys)){ 
 $result[$k] = $url; 
   } 
  } 
  return $result?$result:array(); 
 } 
 /** 
  * 用来找到字符串里面命中的停止词 
  * @access public 
  * @return array $keys 返回匹配到的词array(key,...) 
  */
 public function hits_stop_keys(){ 
  $ar = $this->stopkeys; 
  $ar = $ar?$ar:array(); 
  $result=array(); 
  $str = $this->text; 
  foreach($ar as $k){ 
   $k = trim($k); 
   if(!$k) 
 continue; 
   if(strpos($str,$k)!==false && in_array($k,$this->stopkeys)){ 
 $result[] = $k; 
   } 
  } 
  return $result?$result:array(); 
 } 
 /** 
  * 处理替换过程  
  * @access private 
  * @param string $text 被替换者 
  * @param string $key 关键词 
  * @param string $url 链接 
  * @return string $text 处理好的文章 
  */
 private function r_s($text,$key,$url){ 
  $tmp = $text; 
  $stop_keys = $this->hits_stop_keys(); 
  $stopkeys = $tags = $a = array(); 
  if(preg_match_all("#<a[^>]+>[^<]*</a[^>]*>#su",$tmp,$m)){ 
   $a=$m[]; 
   foreach($m[] as $k=>$z){ 
 $z = preg_replace("#\##s","\#",$z); 
 $tmp = preg_replace('#'.$z.'#s',"[_a".$k."_]",$tmp,); 
   } 
  }; 
  if(preg_match_all("#<[^>]+>#s",$tmp,$m)){ 
   $tags = $m[]; 
   foreach($m[] as $k=>$z){ 
 $z = preg_replace("#\##s","\#",$z); 
 $tmp = preg_replace('#'.$z.'#s',"[_tag".$k."_]",$tmp,); 
   } 
  } 
  if(!empty($stop_keys)){ 
   if(preg_match_all("#".implode("|",$stop_keys)."#s",$tmp,$m)){ 
 $stopkeys = $m[]; 
 foreach($m[] as $k=>$z){ 
  $z = preg_replace("#\##s","\#",$z); 
  $tmp = preg_replace('#'.$z.'#s',"[_s".$k."_]",$tmp,); 
 } 
   } 
  } 
  $key = preg_replace("#([\#\(\)\[\]\*])#s","\\\\$",$key); 
  if($this->url) 
   $tmp = preg_replace("#(?!\[_s|\[_a|\[_|\[_t|\[_ta|\[_tag)".$key."(?!ag\d+_\]|g\d+_\]|\d+_\]|s\d+_\]|_\])#us",'<a href="'.$url.'">'.$key.'</a>',$tmp,$this->all?-:); 
  else
   $tmp = preg_replace("#(?!\[_s|\[_a|\[_|\[_t|\[_ta|\[_tag)".$key."(?!ag\d+_\]|g\d+_\]|\d+_\]|s\d+_\]|_\])#us",$url,$tmp,$this->all?-:); 
  if(!empty($a)){ 
   foreach($a as $n=>$at){ 
 $tmp = str_replace("[_a".$n."_]",$at,$tmp); 
   }   
  }   
  if(!empty($tags)){ 
   foreach($tags as $n=>$at){ 
 $tmp = str_replace("[_tag".$n."_]",$at,$tmp); 
   }   
  }   
  if(!empty($stopkeys)){ 
   foreach($stopkeys as $n=>$at){ 
 $tmp = str_replace("[_s".$n."_]",$at,$tmp); 
   }   
  }   
  return $tmp; 
 } 
}


?>
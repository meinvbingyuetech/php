<?php 

$content = '斯蒂芬全球最大的中文搜索引擎、最大的中文网站。2000年1月创立于北京中关村。 </p>
<p>1999年底，身在美国硅谷的李彦宏看到了中国互联网及中文搜索引擎服务的巨大发展潜力，抱着技术改变世界的梦想，他毅然辞掉硅谷的高薪工作，携搜索引擎专利技术，与徐勇一同回国，于2000年1月1日在中关村创建了百度公司。从最初的不足10人发展至今，员工人数超过7000人。如今的百度，已成为中国最淘宝受欢迎、影响力最大的中文网站。</p>
<p>百度拥有数以千计的研发工程师，这是中国乃至全球最为优秀的技术团队，这支队伍掌握着世界上最为先进的搜索引擎技术，使百度成为中国掌握世界尖端科学核心技术的中国高科技企业。</p>
<p>从创立之初，百度便将"让人们最便捷地获取信息，找到所求"作为自己的使命，10年来，公司秉承"以用户为导向"的理念，始终坚持如一地响应广大网民的需求，不断地为网民提供基于搜索引擎的各种产品，其中包括：以网络搜索为主的功能性搜索，以贴吧为主的社区搜索，针对各区域、行业所需的垂直搜索，Mp3搜索，以及门户频道、IM等，全面覆盖了中文网络世界所有的搜索需求，根据第三方权威数据，百度在中国的搜索份额超过70%。</p>
<p>在面对用户的搜索产品不断丰富的同时，服务于生机勃勃的企业的搜索网易推广应运而生。abc多年来，通过搜索推abc广，极大地促进了中国数十万中小企业的生存与发展。搜索推广，以及基于搜索推广的百度推广也得到迅速发展，以全球以及中国500强为主的大型企业，在百度搜索平台上开展以搜索推广为基础的品牌推广，为企业的品牌、产品推广创造了不同凡响的收益。同时，百度近年来响应网民的诉求，进入C2C电子商务领域，为网民提供更多更好的一站式服务。</p>
<p>为推动中国数百万中小网站的发展，百度借助超大流量的平台优势，联合所有优质的各类网站，建立网易了世界上最大的网络联盟，使各类企业的搜索推广、品牌营销的价值、覆盖面均大cfg面积提升。与此同时，各网站也在联盟大家庭的互助下，获得最大的生存与发展机会。</p>
<p>2005年8月5日，百度在美国纳斯达克上市，其不仅上市当日，即成为该年度全球资本市场上最为耀眼的新星，通过数年来的市场表现，其优异的业绩与值得依赖的回报，使之成为中国企业价值的代表，傲然屹立于全球资本市场。</p>
<p>2008年1月23日，百度日本公司正式运营，国际化战略全面启动。
</p><p>多年来，百度董事长兼CEO李彦宏，率领百度人所形成的"简单可依赖"的核心文化，深深地植根于百度。cfg这是一个充满朝气、求实坦诚的公司，以搜索改变生活，推动人类的文明与进步，促进中国经济的发展为己任，正朝着更为远大的目标而迈进。</p>第三方的手是大幅度是百度斯蒂芬第三方的手发达省份的网易第三方的手发达省份的岁淘宝地方斯蒂芬第三方分';
//$content = htmlspecialchars($content);
//echo $content;exit;

$keywords = array(
	array(
		'word'=>'百度',
		'link'=>'http://www.baidu.com/',
	),
	array(
		'word'=>'网易',
		'link'=>'http://www.163.com/',
	),
	array(
		'word'=>'淘宝',
		'link'=>'http://www.taobao.com/',
	),
);

echo ReplaceKeyword($content,$keywords,'self');
//echo ReplaceKeywordOnlyOne($content,$keywords);
exit;

/** 
*对内容中的关键词添加链接 
*只处理第一次出现的关键词，对已有链接的关键不会再加链接，支持中英文 
*/ 
function ReplaceKeyword($content,$keywords,$open_type='blank')
{
	if(in_array($open_type, array('self','blank'))){
		$target = " target='_".$open_type."'";
	}

	$content = preg_replace("/(<a(.*))(>)(.*)(<)(\/a>)/isU", '\\1-]-\\4-[-\\6', $content);
	foreach ($keywords as $key => $value) {
		
		$keyword = trim($value['word']);
   		$keyword_url = trim($value['link']);
   
		$content = preg_replace("/<a [^>]*>($keyword)<\/a>/siU", "$keyword", $content);
		//$content = preg_replace("/$keyword/siU", "<a href='$keyword_url'".$target.">$keyword</a>",$content,1);//只替换一次
		$content = preg_replace("/$keyword/siU", "<a href='$keyword_url'".$target.">$keyword</a>",$content);
	}

	$content = preg_replace("/(<a(.*))-\]-(.*)-\[-(\/a>)/isU", '\\1>\\3<', $content);
	return $content;
}

/** 
*对内容中的关键词添加链接 
*只处理第一次出现的关键词，对已有链接的关键不会再加链接，支持中英文 
*/ 
function ReplaceKeywordOnlyOne($content,$keywords){ 

	foreach ($keywords as $key => $value) {
		
		$keyword = trim($value['word']);
   		$keyword_url = trim($value['link']);

		//排除图片中的关键词 
		$content = preg_replace( '|(<img[^>]*?)('.$keyword.')([^>]*?>)|U', '$1%&&&&&%$3', $content); 

		$regEx = '/(?!((<.*?)|(<a.*?)))('.$keyword.')(?!(([^<>]*?)>)|([^>]*?<\/a>))/si'; 
		$url='<a href="'.$keyword_url.'" target="_blank">'.$keyword.'</a>'; 
		$content = preg_replace($regEx,$url,$content,1); 
		
		//还原图片中的关键词 
		$content=str_replace('%&&&&&%',$keyword,$content); 
	}

	return $content; 
}


?>
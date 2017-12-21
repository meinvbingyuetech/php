<?php
require_once (dirname(__FILE__) .
"/config.php");
$dsql = new DedeSql(false);

//中间主体内容
$sql = "select a.title,a.subject,a.year,a.letter,a.content,m.zt from dede_archives as a inner join dede_addonmanhua as m on a.id=m.aid";
$result = mysql_query($sql);
$total = mysql_num_rows($result);
$flag = 1;
while ($row = mysql_fetch_array($result)) {
	$middle .= " '" . addslashes($row[title]) . "'  => array ( 'year' => '$row[year]',
	                                       'letter' => '$row[letter]',
	                                       'content' => '$row[content]',
	                                       'subject' => '$row[subject]',
	                                       'status' => '$row[zt]'
	                                     )";
	if ($total != $flag) {
		$middle .= ",
				";
	}
	$flag++;
}

//连接头部
$content .= "<?php
\$manhua = array( ";

//连接主体
$content .= $middle;

//连接底部
$content .= ");
?>";

echo file_put_contents("test.php", $content);
?>
- 二维数组多字段排序
```php

function sortByCols($list,$field){
	$sort_arr=array();
	$sort_rule='';
	foreach($field as $sort_field=>$sort_way){
		foreach($list as $key=>$val){
			$sort_arr[$sort_field][$key]=$val[$sort_field];
		}
		$sort_rule .= '$sort_arr["' . $sort_field . '"],'.$sort_way.',';
	}
	if(empty($sort_arr)||empty($sort_rule)){ return $list; }
	eval('array_multisort('.$sort_rule.' $list);');//array_multisort($sort_arr['parent'], 4, $sort_arr['value'], 3, $list);
	return $list;
}
$list = array(
	array('id' => 1, 'value' => '1-1', 'parent' => 1),
	array('id' => 2, 'value' => '2-1', 'parent' => 1),
	array('id' => 3, 'value' => '3-1', 'parent' => 1),
	array('id' => 4, 'value' => '4-1', 'parent' => 2),
	array('id' => 5, 'value' => '5-1', 'parent' => 2),
	array('id' => 6, 'value' => '6-1', 'parent' => 3),
);
$list = sortByCols($list, array(
	'parent' => SORT_ASC, 
	'value' => SORT_DESC,
));
print_r($list);exit;
```

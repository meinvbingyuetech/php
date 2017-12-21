<?php

$data = array_filter(explode(" ",$output)); //删除数组空项
$data = array_flip(array_flip($data));      //删除重复项

array(1,2,3);
array(0=>1,1=>2,2=>3);
//上面两个数组效果是一样的，特别是当作为参数传入的时候

array_filter($arr); //去除空数组
//***********************************************************************

//array_reverse()  反序
$arr = array(1, 2, 3, 17);

foreach ($arr as $v) {
	echo $v."<br>";
}
echo "<hr/>";

//***********************************************************************
$arr = array(1, 2, 3, 17);
$i = 0;
foreach ($arr as $v) {
    echo "\$arr[$i] => $v<br>";
    $i++;
}
echo "<hr/>";

//***********************************************************************

$arr = array();
$arr[0][0] = "1";
$arr[0][1] = "2";
$arr[1][0] = "3";
$arr[1][1] = "17";

foreach ($arr as $v1) {
    foreach ($v1 as $v2) {
        echo "$v2<br>";
    }
}
echo "<hr/>";

//***********************************************************************

$arr = array(
    "one" => 1,
    "two" => 2,
    "three" => 3,
    "seventeen" => 17
);

foreach ($arr as $k => $v) {
    echo "\$arr[$k] => $v<br>";
}
echo "<hr/>";

//***********************************************************************
$_REQUEST = array(
    "one" => 1,
    "two" => 2,
    "three" => 3,
    "seventeen" => 17
);
foreach ($_REQUEST as $k => $v) {
	$$k = $v;
}
echo $one." ".$two." ".$three;
echo "<hr/>";

/*********************************************************************************
 * 去除重复的数组元素
 */
$arr = array(1878,18569,1878,18569,956,342,956);
$arr = array_unique($arr);//取出重复
print_r($arr);//得到结果
echo "<hr/>";

/*********************************************************************************
 * 用回调函数过滤数组中的单元
 */
$arr = array_filter($arr, 'is_numeric');

function myfunction($v) {
	if ($v === "Horse") {
		return true;
	}
	return false;
}
$a = array (
	0 => "Dog",
	1 => "Cat",
	2 => "Horse"
);
print_r(array_filter($a, "myfunction"));
echo "<hr/>";

/*********************************************************************************
 * extract($row);
 * 从数组中把变量导入到当前的符号表中。
 * 对于数组中的每个元素，键名用于变量名，键值用于变量值
 * 第二个参数 type 用于指定当某个变量已经存在，而数组中又有同名元素时，extract() 函数如何对待这样的冲突。
 * 本函数返回成功设置的变量数目。
 */
$my_array = array (
	"cat" => "波斯猫",
	"dog" => "哈巴狗",
	"horse" => "千里马"
);
extract($my_array);
echo "$cat -- $dog -- $horse";
?>

<?php
ini_set("display_errors","on");

$p = new person();
echo $p;
echo '<hr>';
$p->get_name('meinv');
echo '<hr>';

$p2 = new person('json');
echo $p2->name;


class person{
	
	private $age;
	private $height;
	public $name;
	
	function __toString(){//魔术方法
		return 'class person';
	}

	function __construct($name){//构造函数
		$this->name = $name;
	}

	function __destruct(){//析构函数
		echo '<br>结束';
	}

	public function test(){
		echo 'hello world!';
	}

	public function get_name($name){
		echo $name;
	}

	public function sport(){
		return "在运动";
	}
}


class man extends person{
	
	function sport(){
		echo "男人".person::sport();
	}

	public function get_name($name,$space){//重载、并调用父类函数
		echo parent::get_name($name).' || '.$name.' - '.$space;
	}

	function test_param($param){//类中的函数也可以使用array参数传值
		$param_a = $param['a'];
		$param_b = $param['b'];
		echo $param_a." - ".$param_b;
	}
}

echo '<hr>';
$m = new man();
echo $m->sport();
echo '<hr>';
$m->test_param(array('a'=>11,'b'=>22));
echo '<hr>';
$m->get_name('煜熙','番禺');
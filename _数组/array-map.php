<?php 

$stock_list = [];

// 清洗数据中不用的字段
$clearData = function($value) {

    unset($value['deleted_at']);
    unset($value['updated_at']);
    unset($value['created_at']);

    return $value;
};

$new = array_map($clearData, $stock_list);


/******************************************************************************************************************/

// 处理ID、code、type数据
$handle_data = array_map(function ($id, $code, $type) {
    return [
        'id' => $id,
        'code' => $code,
        'type' => $type,
    ];
}, $id_arr, $code_arr, $type_arr);
$handle_data = array_column($handle_data, null, 'id');

/******************************************************************************************************************/

class test
{
	
	public function lists()
	{
		$data = array_map([$this, 'handleData'], $data);
	}

	public function handleData(array $data)
	{
		return $data;
	}
}

?>


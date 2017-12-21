<?php

$fields = array('username', 'email','mobile_phone', 'password');
$values = array($username, $email,$mobile, $password);

$fields[] = 'sex';
$values[] = '1';

$sql = "INSERT INTO " . $this->table().
	   " (" . implode(',', $fields) . ")".
	   " VALUES ('" . implode("', '", $values) . "')";


//INSERT语句里用SELECT查询出来的数据
$sql = 'INSERT INTO ' . $GLOBALS['ecs']->table('order_action') .
        ' (order_id, action_user, user_id,order_status, shipping_status, pay_status, action_place, action_note, log_time, refund_reason) ' .
        'SELECT ' .
        "order_id, '$username', user_id,'$order_status', '$shipping_status', '$pay_status', '$place', '$note', '" .gmtime() . "', '$refund_reason' " .
        'FROM ' . $GLOBALS['ecs']->table('order_info') . " WHERE order_sn = '$order_sn'";
$GLOBALS['db']->query($sql);



/**
 * 更新拼装
 * $multipleData = [{"id":7,"sort":1},{"id":8,"sort":1}];
 * @param $tables
 * @param array $multipleData
 * @return bool|string
 * author hxc
 */
public static function updateBatch($tables, $multipleData = array()){

    if(!empty($multipleData) ) {

        // column or fields to update
        $updateColumn = array_keys($multipleData[0]);
        $referenceColumn = $updateColumn[0]; //e.g id
        unset($updateColumn[0]);
        $whereIn = "";
        $q = "UPDATE ".$tables." SET ";
        foreach ( $updateColumn as $uColumn ) {
            $q .=  $uColumn." = CASE ";

            foreach( $multipleData as $data ) {
                $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN '".$data[$uColumn]."' ";
            }
            $q .= "ELSE ".$uColumn." END, ";
        }
        foreach( $multipleData as $data ) {
            $whereIn .= "'".$data[$referenceColumn]."', ";
        }
        $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";
        return $q;

    } else {
        return false;
    }
}
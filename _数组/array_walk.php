<?php 

/**
 * 传递数据给后台服务端时，将为数组的数据json_encode
 *
 * @author jilin
 */
public static function dataJsonEncode(array $data = [])
{
    array_walk($data, function (&$value, $key) {
        $value = is_array($value) ? json_encode($value) : $value;
    });
    return $data;
}

?>

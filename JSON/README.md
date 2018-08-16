```php
/**
 * 提供json格式化输出
 * @param string $json_data
 */
public static function outputJson($json_data = array()) {
    @header("Cache-Control: no-cache, must-revalidate");
    @header("Pragma: no-cache");
    @header("Content-Type:application/json");      

    echo @json_encode($json_data);
}
```

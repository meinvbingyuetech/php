```php

public static function outputJson($json_data = array()) {
    @header("Cache-Control: no-cache, must-revalidate");
    @header("Pragma: no-cache");
    @header("Content-Type:application/json");      

    echo @json_encode($json_data);
}
```

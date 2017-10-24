```php
$arr = [
    'name1' => 'xiner',
    'name2' => 'jason',
];

## 写法一
function handle(&$value, $key, array $param = [])
{
    $value = $value.'-aaaaaaaaaaaaaaaa'.$param[0].$param[1];
}
array_walk($arr, 'handle', ['-bbbbbbb','-cccccccc']);
print_r($arr);

## 写法二
$handle = function (&$value, $key, array $param = []) {
    $value = $value.'-aaaaaaaaaaaaaaaa'.$param[0].$param[1];
};
array_walk($arr, $handle, ['-bbbbbbb','-cccccccc']);
print_r($arr);

```

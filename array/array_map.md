```php
$arr = [
    'name1' => 'xiner',
    'name2' => 'jason',
];

## 写法一
function cube($value, $param)
{
    return $value .'2'. $param;
}
$b = array_map("cube", $arr, [3,3]);
print_r($b);

## 写法二
$cube = function ($value, $param) {
    return $value .'2'.$param;
};
$b = array_map($cube, $arr, [3,3]);
print_r($b);
```

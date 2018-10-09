```php
use Intervention\Image\ImageManagerStatic as Image;

$full_path = '/home/test/upload/1.jpg'; // 绝对路径和相对路径都可以
$img = Image::make($full_path);
$img->save($full_path, 50);             // 压缩50%, 保存的话也可以另存为2.jpg，不覆盖原图
```

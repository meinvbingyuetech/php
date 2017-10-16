```php

// 判断当前时间是否大于早上9点
$nine = Carbon::create(date('Y', time()),date('m', time()),date('d', time()),9,0,0);
Carbon::now()->gte($nine)

```

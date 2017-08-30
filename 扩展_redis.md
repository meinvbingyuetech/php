## 扩展包下载
http://pecl.php.net/package/redis

## 安装PHP的 redis 扩展
```
tar zxvf redis-3.1.0.tgz
cd redis-3.1.0
/usr/local/php/bin/phpize
./configure --enable-redis --with-php-config=/usr/local/php/bin/php-config --prefix=/usr/local/phpredis
make && make install
```
## 加入php扩展
- vim /usr/local/php/etc/php.ini
- 文件尾部加入： extension=redis.so 或 extension=/usr/local/php/lib/php/extensions/no-debug-non-zts-20131226/redis.so

## 重启&测试
- systemctl restart php-fpm
- php -m | grep redis
- 测试脚本
```php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

echo "Server is running: " . $redis->ping() . '<br>';

$redis->SET('name', 'jason');

echo $redis->GET('name');
```

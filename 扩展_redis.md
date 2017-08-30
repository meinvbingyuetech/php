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

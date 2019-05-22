# 方法一
```
vim /etc/php.d/amqp.ini
```

写入以下代码

```
extension = amqp.so
```

# 方法二
```
vim /usr/local/php/etc/php.ini 或者 vim /etc/php.ini

如果还是没有，可以用whereis php.ini查找

```

写入以下代码

```
extension = amqp.so
```

----

# 最后都要重启一下

```
systemctl restart php-fpm
```

# 检查是否加载成功

```
php -m | grep swoole
```

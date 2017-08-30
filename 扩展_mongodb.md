## 下载扩展包
### http://pecl.php.net/package/mongodb
wget http://pecl.php.net/get/mongodb-1.2.9.tgz
 
## 安装
- tar zxvf mongodb-1.2.9.tgz
- cd mongodb-1.2.9
- /usr/local/php/bin/phpize
- ./configure --enable-mongodb --with-php-config=/usr/local/php/bin/php-config --prefix=/usr/local/phpmongodb
- make && make install
 
## 绑定so文件
- vim /usr/local/php/etc/php.ini
```
extension=/usr/local/php/lib/php/extensions/no-debug-non-zts-20160303/mongodb.so
```

## 重启&测试
- systemctl restart php-fpm
- php -m | grep mongod

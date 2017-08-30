```
http://pecl.php.net/package/memcache

注意：php7可能会有问题
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

安装必要扩展
yum -y install zlib zlib-devel


安装 libmemcached
1.	tar zxvf libmemcached-1.0.18.tar.gz
2.	cd libmemcached-1.0.18
3.	./configure --prefix=/usr/local/libmemcached --with-memcached
4.	make && make install


安装PHP的memcached 扩展
1.	tar zxvf memcached-2.2.0.tgz
2.	cd memcached-2.2.0
3.	/usr/local/php/bin/phpize 【这里是php的安装目录】
4.	./configure --enable-memcached --with-php-config=/usr/local/php/bin/php-config --with-zlib-dir --with-libmemcached-dir=/usr/local/libmemcached --prefix=/usr/local/phpmemcached --disable-memcached-sasl
5.	make && make install


打开 php.ini 文件，在最后面添加：
extension=memcached.so				##### 也可以指定完整路径：extension=/usr/local/php/lib/php/extensions/no-debug-non-zts-20131226/memcached.so  


然后重启php-fpm

phpinfo()检查是否加载成功

-------------------------------------------------------------------------------------------------------------------------------------------------
写个文件测试一下：
<?php
$m = new Memcached();             //创建一个memcache对象
$m->addServer('localhost', 11211);//连接Memcached服务器
$m->set('name', 'meinvbingyue');  //设置一个变量到内存中，名称是key 值是test
$get_value = $m->get('name');     //从内存中取出key的值
echo $get_value;
?>

更多操作，请查看官方文档:
http://php.net/manual/zh/book.memcached.php
```

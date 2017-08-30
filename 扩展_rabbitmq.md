# 安装rabbitmq-c-0.7.1

## https://github.com/alanxz/rabbitmq-c/releases/

```
wget https://github.com/alanxz/rabbitmq-c/releases/download/v0.8.0/rabbitmq-c-0.8.0.tar.gz
tar zxvf rabbitmq-c-0.8.0.tar.gz
cd rabbitmq-c-0.8.0
./configure --prefix=/usr/local/rabbitmq-c
make && make install
```

# 安装amqp扩展

## https://pecl.php.net/package/amqp

```
wget https://pecl.php.net/get/amqp-1.9.1.tgz
tar zxvf amqp-1.9.1.tgz
cd amqp-1.9.1

find / -name phpize

/usr/local/php/bin/phpize

./configure --with-php-config=/usr/local/php/bin/php-config --with-amqp --with-librabbitmq-dir=/usr/local/rabbitmq-c

make && make install

```

# 加入php扩展

```
vim /usr/local/php/etc/php.ini 

extension = amqp.so

systemctl restart php-fpm
```

# 测试

- php -m | grep amqp

- vim test.php

```php
$conn = new AMQPConnection();
$conn->setHost('127.0.0.1');
$conn->setLogin('admin');
$conn->setPassword('admin');
if($conn->connect()){
	echo 'connect success';
}else{
	echo 'connect fail';
}
```

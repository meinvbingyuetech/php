## 下载扩展包
- http://pecl.php.net/package/mongodb
- wget http://pecl.php.net/get/mongodb-1.2.9.tgz
 
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

## 测试脚本
```php
try {

    //服务器状态
    echo PHP_EOL;
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

    $stats = new MongoDB\Driver\Command(["dbstats" => 1]);
    $res = $mng->executeCommand("test", $stats);
    
    $stats = current($res->toArray());
    print_r($stats);

    //查询数据---前提要在数据库创建了test库，user表
    echo PHP_EOL;

    $query = new MongoDB\Driver\Query([]); 
     
    $rows = $mng->executeQuery("test.user", $query);
    
    foreach ($rows as $row) {
    
        echo "用户名：$row->name".PHP_EOL;
    }

} catch (MongoDB\Driver\Exception\Exception $e) {

    $filename = basename(__FILE__);
    
    echo "The $filename script has experienced an error.".PHP_EOL; 
    echo "It failed with the following exception:".PHP_EOL;
    
    echo "Exception:", $e->getMessage().PHP_EOL;
    echo "In file:", $e->getFile().PHP_EOL;
    echo "On line:", $e->getLine().PHP_EOL;       
}
```

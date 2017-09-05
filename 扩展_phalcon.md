# 安装

```
git clone --depth=1 "git://github.com/phalcon/cphalcon.git"
cd cphalcon/build
./install
```

#### 或

```
# 下载安装包
wget https://github.com/phalcon/cphalcon/archive/v3.0.1.tar.gz

# 重命名
mv v3.0.1.tar.gz cphalcon-3.0.1.tar.gz

#解压
tar -zxvf cphalcon-3.0.1.tar.gz

#切换目录（根据php版本和操作系统位数切换到相应的目录）
cd cphalcon-3.0.1/build/php7/64bits/

#准备环境（通过find / -name phpize 命令可查找出phpize的完整路径）
/usr/local/php/bin/phpize

#编译（通过find / -name php-config 命令可查找出php-config的完整路径）
./configure --with-php-config=/usr/local/php/bin/php-config

#安装
make && make install
```

**如果配置比较底，编译会有一段时间，请耐心等待....**

---

# 添加扩展

```
vim /etc/php.d/phalcon.ini

输入：
extension=/usr/lib64/php/modules/phalcon.so
```
#### 或

```
vim /etc/php.ini

extension=/usr/lib64/php/modules/phalcon.so
```

# 测试
- systemctl restart php-fpm

- php -m | grep phalcon

# demo

- 链接：http://pan.baidu.com/s/1kUPlTY3 密码：1duq

- mkdir -p /home/wwwroot/phalcon/test
- mv /vagrant/www/phalcon/* /home/wwwroot/phalcon/test/
- vim /etc/nginx/conf.d/phalcon.test.conf
```
server {
    listen 80;
    server_name phalcon.test;
    root /home/wwwroot/phalcon/test/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        #try_files $uri /index.php =404;
        #fastcgi_split_path_info ^(.+\.php)(/.+)$;
    }
}

```
- systemctl restart nginx
- http://phalcon.test/

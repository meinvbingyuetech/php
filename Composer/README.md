- 安装
	* 依次执行
	```
	php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"
	```
	
- 国内镜像
	```
	composer config -g repo.packagist composer https://packagist.phpcomposer.com
	```
	
	* 查看是否设置成功
	```
	cd /root/.composer/
	cat config.json
	```

- 查看配置
	```
	composer config -gl
	```

- composer create-project --prefer-dist laravel/laravel blog -vvv
	```
	--prefer-dist
	为了强制使用压缩包，而不是克隆源代码。

	blog
	为指定安装目录
	
	-vvv
	查看调试信息
	```

- composer create-project --prefer-dist laravel/lumen 

- composer create-project "laravel/laravel:v5.4.30"
 
- composer require "predis/predis:1.0.4"

- composer require roumen/sitemap


----

- 创建 composer.json
	```
	{
	  "require": {
	      "php-amqplib/php-amqplib": "2.7.*",
	      "monolog/monolog": "1.18.1"
	  }
	}
	```
 
 - 指定更新
	```
	composer update monolog/monolog
	```



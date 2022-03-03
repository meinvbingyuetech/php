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
	
	composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/   (阿里云)
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


----

# composer.lock  会锁定 Composer 加载的依赖包版本号，防止由于第三方依赖包的版本不同导致的应用运行错误。

### composer install  --no-autoloader --no-scripts 
- --no-autoloader  为了阻止 composer install  之后进行的自动加载，防止由于代码不全导致的自动加载报错。
- --no-scripts  为了阻止 composer install  运行时 composer.json  所定义的脚本，同样是防止代码不全导致的加载错误问题。

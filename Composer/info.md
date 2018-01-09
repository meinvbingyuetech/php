- 查看配置
	```
	composer config -gl
	```

- composer create-project --prefer-dist laravel/laravel blog
	```
	--prefer-dist
	为了强制使用压缩包，而不是克隆源代码。

	blog
	为指定安装目录
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
 - 单独引入
	 ```
	 composer update monolog/monolog
	 ```



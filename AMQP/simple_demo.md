- 创建composer.json
```json
{
  "require": {
      "php-amqplib/php-amqplib": "2.7.*"
  }
}
```

- 安装
```
composer update
```

- sender.php
```php
<?php

require_once __DIR__.'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'admin');
$channel = $connection->channel();







$exchange_name = 'test';
$channel->exchange_declare($exchange_name, 'fanout', false, false, false);

$data = "\nHello Hello World!".time()."\n";
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, $exchange_name);

$channel->close();
$connection->close();
```

- receive.php
```
<?php
require_once __DIR__.'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'admin');
$channel = $connection->channel();







$exchange_name = 'test';
$channel->exchange_declare($exchange_name, 'fanout', false, false, false);

list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

$channel->queue_bind($queue_name, $exchange_name);

$callback = function($msg){
  echo ' [x] ', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
```

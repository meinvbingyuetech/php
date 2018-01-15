```php
/*
declare	[dɪˈkleə(r)] 声明，宣布
delivery  [dɪˈlɪvəri]  传送，投递
durable [ˈdjʊərəbl] 持久的
QoS（Quality of Service，服务质量）


生产者是发送消息的用户应用程序
队列是存储消息的缓冲区
消费者是接收消息的用户应用程序

queue 就像是MQ内部的邮箱。多个生产者可以向一个队列发送消息，多个消费者也可以尝试从一个队列接收数据。

信息交换中间件(exchange)。信息交换中间件只做一件非常简单的事：一方面，它接收来自生产者的消息; 另一方面将接收到的消息推送到队列。信息交换中间件准确知道接收到的消息如何处理。应该添加到特定的队列？ 应该添加到许多的队列中？或者应该丢弃。其规则由交换类型定义(direct, topic, headers, fanout<广播消息>)。

不能正常发送消息，可能是RabbitMQ 代理没有足够的的硬盘空间(默认至少需要 200MB)

声明一个队列是幂等的 - 只有当它不存在时才会被创建。

** 生产者只关注交换机，交换机去绑定队列，数据最终流向消费者，消费者只关注队列 **

fanout 交换非常简单，它只是将所有的消息广播到所有已知的队列。


#列出RabbitMQ中的队列
rabbitmqctl list_exchanges

#列出RabbitMQ中的绑定
rabbitmqctl list_bindings

#列出RabbitMQ中的交换机
rabbitmqctl list_queues 	

#忘记发送确认消息是一个常见的错误，并且这是一个很容易犯的错误，但是它的后果是很严重的。当你的客户端退出时，消#息#将被重新发送，但RabbitMQ将会消耗越来越多的内存，因为它将无法释放任何没有确认信息的消息。
#为了调试这种错误，你可以使用 rabbitmqctl 打印 messages_unacknowledged 字段：
rabbitmqctl list_queues name messages_ready messages_unacknowledged


# 如果所有的消费者进程都处于忙碌状态，你的队列可能会溢出。你应该留意一下这种情况，也许你可以增加更多的消费者进程，或者采取一些其他的策略。

list($queue_name, ,) = $channel->queue_declare("");  #创建一个随机名称的非持久化的队列


#绑定：交换机与队列的关系，如下面这句代码意思是，$queue_name队列对logs交换机数据感兴趣，该队列就消费该交换机传过来的数据：这个队列（queue）对这个交换机（exchange）的消息感兴趣. $binding_key默认为空，表示对该交换机所有消息感兴趣，如果值不为空，则该队列只对该类型的消息感兴趣（除了fanout交换机以外）
$channel->queue_bind($queue_name, 'logs', $binding_key);

#该代码表示使用basic.qos方法，并设置prefetch_count=1。这样是告诉RabbitMQ，再同一时刻，不要发送超过1条消息给一个工作者（worker），直到它已经处理了上一条消息并且作出了响应。这样，RabbitMQ就会把消息分发给下一个空闲的工作者（worker），轮询、负载均衡配置
$channel->basic_qos(null, 1, null);

#监听消息，一有消息，立马就处理
while(count($channel->callbacks)) {
    $channel->wait();
}

public function basic_publish(
        $msg,
        $exchange = '',
        $routing_key = '',
        $mandatory = false,
        $immediate = false,
        $ticket = null
    )


public function basic_consume(
        $queue = '',
        $consumer_tag = '',
        $no_local = false,
        $no_ack = false,
        $exclusive = false,
        $nowait = false,
        $callback = null,
        $ticket = null,
        $arguments = array()
    )

public function exchange_declare(
        $exchange,
        $type,
        $passive = false,
        $durable = false,
        $auto_delete = true,
        $internal = false,
        $nowait = false,
        $arguments = null,
        $ticket = null
    )

public function queue_declare(
        $queue = '',
        $passive = false,
        $durable = false,
        $exclusive = false,
        $auto_delete = true,
        $nowait = false,
        $arguments = null,
        $ticket = null
    )

public function queue_bind(
		$queue, 
		$exchange, 
		$routing_key = '', 
		$nowait = false, 
		$arguments = null, 
		$ticket = null
	)    
*/

require_once __DIR__.'/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/***************************************************************************
Demo1
*/
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('queue_name', false, false, false, false);

$data = "Hello World!";
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, '', 'queue_name'); //使用默认或无名交换机

$channel->close();
$connection->close();

##########################################

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('queue_name', false, false, false, false);

$callback = function($msg) {
  echo " [x] Received ", $msg->body, "\n";
};
$channel->basic_consume('queue_name', '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

/***************************************************************************
Demo2
任务队列，持久化，
*/

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('queue_name', false, true, false, false); // 第三个参数设置为 true，将队列声明为持久化

$data = "Hello World!";
$msg = new AMQPMessage($data,[
		'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,	//消息标记为持久化
	]);

$channel->basic_publish($msg, '', 'queue_name');

$channel->close();
$connection->close();

##########################################

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('queue_name', false, true, false, false);

$callback = function($msg){
  echo " [x] Received ", $msg->body, "\n";
  $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']); //发送确认消息(应答)
};

$channel->basic_qos(null, 1, null); // 告诉RabbitMQ在确认前一个消息之前，不要向消费者发送新的消息。

$channel->basic_consume('queue_name', '', false, false, false, false, $callback); // 开启消息确认机制,将basic_consumer的第四个参数设置为false(true表示不开启消息确认)，并且工作进程处理完消息后发送确认消息。

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

/***************************************************************************
Demo3
订阅、发布 Publish/Subscribe
*/

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$exchange_name = 'logs_exchange';
$channel->exchange_declare($exchange_name, 'fanout', false, false, false);

$data = 'Hello World!';
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, $exchange_name);

$channel->close();
$connection->close();

##########################################

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$exchange_name = 'logs_exchange';
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

/***************************************************************************
Demo4
使用路由
*/

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$exchange_name = 'logs_exchange';
$channel->exchange_declare($exchange_name, 'direct', false, false, false);

$routing_key = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : 'info';

$data = "Hello World!";
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, $exchange_name, $routing_key);

$channel->close();
$connection->close();

##########################################

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$exchange_name = 'logs_exchange';
$channel->exchange_declare($exchange_name, 'direct', false, false, false);

list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

foreach($routing_keys as $routing_key) {
    $channel->queue_bind($queue_name, $exchange_name, $routing_key);
}

$callback = function($msg){
  echo ' [x] ',$msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

/***************************************************************************
Demo4
Topic exchange

Q1 binding key -> *.orange.*
Q2 binding key -> *.*.rabbit ，lazy.#

Q1 对所有橙色的动物感兴趣。 
Q2 想要获取有关兔子的一切消息，以及所有惰性动物的一切。

即使匹配了N个 binding key，消息将只会被传递一次；不匹配则丢弃

lazy.orange.male.rabbit 即使它有四个单词，但它能匹配最后一个绑定，并且将被传递到Q2中。


收听所有日志：
php receive_logs_topic.php "#"

收听所有来自 kern 的日志：
php receive_logs_topic.php "kern.*"

只收听 “critical” 类型的日志：
php receive_logs_topic.php "*.critical"

创建多个绑定：
php receive_logs_topic.php "kern.*" "*.critical"


发出 routing key为 “kern.critical”类型的日志
php emit_log_topic.php "kern.critical" "A critical kernel error"
*/

```

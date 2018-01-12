```php

//require 'vendor/autoload.php';

$conn_args = array(
    'host'=>'192.168.11.68',
    'port'=>5672,
    'login'=>'xianli',
    'password'=>'123456',
    'vhost'=>'/stock_assistant'
);
$e_name = 'assistant_rank_exchange';
$q_name = 'assistant_rank_queue3';
$k_route = 'assistant_rank_route';


$conn = new AMQPConnection($conn_args);
if(!$conn->connect()){
    die('Cannot connect to the broker');
}
$channel = new AMQPChannel($conn);
$ex = new AMQPExchange($channel);
$ex->setName($e_name);
$ex->setType(AMQP_EX_TYPE_FANOUT);
$ex->setFlags(AMQP_DURABLE);

$q = new AMQPQueue($channel);
//var_dump($q);
$q->setName($q_name);
$q->bind($e_name, $k_route);

while(true){
    $arr = $q->get();
//    var_dump($arr);
    $res = $q->ack($arr->getDeliveryTag());

    echo "response ------ \n";
//    $msg = $arr->getBody();
//    $data = json_decode($msg,true);
//    echo $data['type']."\n";
}
```

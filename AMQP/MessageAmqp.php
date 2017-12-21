<?php

namespace App\Http\Common;

use App\Exceptions\JsonException;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class MessageAmqp
 * 用于推送消息的队列对象..多单例模式，简单封装而已
 * @package App\Http\Common
 */
class MessageAmqp{
    
    //保存实例
    private static $instance = array();
    
    //保存rabbitmq链接对象
    private $rabbitmq = null;
    
    //保存频道
    private $channels = array();

    //保存一个频道
    private $channel = null;
    
    //使用哪个配置
    private $config;
    
    /**
     * 构造方法，初始化
     * @author  jianwei
     */
    private function __construct($config)
    {
        //判断此配置是否有效
        //$config_arr = config('stockbusiness.mq.'.$config);
        $config_arr = config('rabbitmq.connection.'.$config);

        if(empty($config_arr)){
            throw new JsonException(20016);
        }
        
        $this->setConfig($config_arr);
        
        //链接到rabbitmq
        $this->rabbitmq = $this->amqpConnection();
    }
    
    /**
     * 获取配置
     * @author  jianwei
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    /**
     * 设置配置
     * @author  jianwei
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
    
    /**
     * 禁止克隆
     * @author  jianwei
     */
    private function __clone()
    {
    
    }
    
    /**
     * 入口,
     * @author  jianwei
     * @param $config   读取哪个配置
     */
    public static function getInstance($config)
    {
        if(!isset(self::$instance[$config]) || !(self::$instance[$config] instanceof self) )
        {
            self::$instance[$config] = new self($config);
        }
        
        return self::$instance[$config];
    }
    
    /**
     * 创建amqp链接
     * @author  jianwei
     */
    private function amqpConnection()
    {
        $config = $this->getConfig();
        $read_write_timeout = isset($config['read_write_timeout']) ? $config['read_write_timeout'] : ($config['heartbeat'] > 0 ? $config['heartbeat'] * 2 : 3.0);
        //加入对应的队列
        $rabbitmq_connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['username'],
            $config['password'],
            $config['vhost'],
            false,
            'AMQPLAIN',
            null,
            'en_US',
            5.0,
            $read_write_timeout,
            null,
            false,
            $config['heartbeat']
        );
        
        return $rabbitmq_connection;
    }
    
    /**
     * 获取链接实例
     * @author  jianwei
     */
    public function getAmqpConnection()
    {
        return $this->rabbitmq;
    }
    
    /**
     * 获取一个频道，并且初始化一个交换机,队列什么的
     * @author  jianwei
     */
    public function getChannel()
    {
        $config = $this->getConfig();
        //交换机类型
        $exchange_type = $config['exchange_type'];
        //交换机名称
        $exchange_name = $config['exchange_name'];
        //队列名称
        $queue_name = $config['queue_name'];
        //路由名称
        $route_name = $config['route_name'];
        //每个客户端接收多少个消息
        $queue_qos = isset($config['qos']) ? $config['qos'] : 50;
    
        //获取一个频道
        $channel = $this->rabbitmq->channel();
    
        //设置 qos 值，每次只取 多少条数据
        $channel->basic_qos(0,$queue_qos,false);
    
        //创建一个队列
        //第三个参数的意思是把队列持久化
        //第五个参数是自动删除，当没有消费者连接到该队列的时候，队列自动销毁。
        $channel->queue_declare($queue_name,false,true,false,false);
    
        //创建交换机，当不存在的时候就创建，存在则不管了
        //第二个参数为交换机的类型
        //第四个参数的意思是把队列持久化
        //第五个参数的意思是自动删除，当没有队列或者其他exchange绑定到此exchange的时候，该exchange被销毁。
        $channel->exchange_declare($exchange_name,$exchange_type,false,true,false);
    
        //把队列与交换机以及路由绑定起来
        $channel->queue_bind($queue_name,$exchange_name,$route_name);
    
        $this->channels[$channel->getChannelId()] = $channel;
        
        return $channel;
    }
    
    /**
     * 获取一个频道
     * @author  jianwei
     */
    public function getOneChannel()
    {
        if($this->channel === null){
            $this->channel = $this->getChannel();
        }
        
        return $this->channel;
    }

    /**
     * 推送消息到队列
     * @author jingchang
     * @param $msg array 消息
     */
    public function basic_publish(array $msg)
    {
        //格式化
        $msg_str = json_encode($msg);

        $property = ['delivery_mode'=>AMQP_DURABLE];
        $amqp_message = new AMQPMessage($msg_str,$property);

        //交换机名称
        $config = $this->getConfig();
        $exchange_name = $config['exchange_name'];
        //路由名称
        $route_name = $config['route_name'];

        $response = $this->getOneChannel()->basic_publish($amqp_message,$exchange_name,$route_name);

        return $response;
    }
    
    /**
     * 解构函数,关闭链接跟频道
     * @author  jianwei
     */
    public function __destruct()
    {
        //关闭频道
        foreach($this->channels as $sk=>$sv){
            $sv->close();
        }
        //关闭链接
        $this->rabbitmq->close();
    }
    
}

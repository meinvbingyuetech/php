<?php

namespace App\Http\Common;

use App\Exceptions\JsonException;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class Factory
 * 工厂类
 * @package App\Http\Common
 */
class Factory{
    
    
    /**
     * 根据配置生成amqp链接
     * @author  jianwei
     * @param $config   string
     * @return AMQPStreamConnection;
     */
    public static function rabbitmq($config)
    {
        static $connections = array();
        
        if(isset($connections[$config])){
            return $connections[$config];
        }
        
        $rabbitmq_connection_arr = config('rabbitmq.connection');
        
        //当配置不存在，抛出错误
        if(!isset($rabbitmq_connection_arr[$config])){
            throw new JsonException(30000);
        }
        
        //创建链接
        $this_config_arr = $rabbitmq_connection_arr[$config];
        $heartbeat = isset($this_config_arr['heartbeat']) ? $this_config_arr['heartbeat'] : 50;
        $read_write_timeout = isset($this_config_arr['read_write_timeout']) ? $this_config_arr['read_write_timeout'] : ($heartbeat > 0 ? $heartbeat * 2 : 3.0);
        $amqp_connection = new AMQPStreamConnection(
            $this_config_arr['host'],
            $this_config_arr['port'],
            $this_config_arr['username'],
            $this_config_arr['password'],
            $this_config_arr['vhost'],
            false,
            'AMQPLAIN',
            null,
            'en_US',
            5.0,
            $read_write_timeout,
            null,
            false,
            $heartbeat
        );
        
        //保存此链接
        $connections[$config] = $amqp_connection;
        
        //返回链接
        return $amqp_connection;
    }
    
}

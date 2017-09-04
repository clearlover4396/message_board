<?php

class RedisApi {
    public $host = '127.0.0.1';
    public $port = 6379;
    public $timeout = 0;

    private $redis;

    public function __construct($host='127.0.0.1', $port=6379, $timeout=0)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;

        $this->redis = new Redis();
        $this->redis->connect($this->host, $this->port, $this->timeout);
    }

    public function __destruct()
    {
        $this->redis->bgsave();
        $this->redis->close();
    }

    /**
     * 自增
     */
    public function Incr($key)
    {
        return $this->redis->incr($key);
    }

    /**
     * Keys *
     */
    public function Keys($pattern)
    {
        return $this->redis->keys($pattern);
    }

    /**
     * String
     * Set
     */
    public function Set($key, $value)
    {
        return $this->redis->set($key, $value);
    }
    /**
     * String Get
     */
    public function Get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * Hash hgetall
     */
    public function HGetall($key){
        return $this->redis->hGetAll($key);
    }

    /**
     * Hash hset
     */
    public function HSet($key, $field, $value)
    {
        return $this->redis->hSet($key, $field, $value);
    }

    /**
     * Hash hdel
     */
    public function Del($MSG_RECORD){
        return $this->redis->del($MSG_RECORD);
    }

    /**
     * Hash update
     */
    public function Update($key, $value1,$value2){
        return $this->redis->hMset($key,array('username' => $value1, 'content' => $value2));
    }

}
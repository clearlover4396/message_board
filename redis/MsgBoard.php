<?php

include_once 'RedisApi.php';

class MsgBoard {
    public $username;
    public $content;
    public $ctime;

    private $redis;

    const MSG_KEY = 'MSG_ID_KEY';
    const PREFIX_MSG_BODY_KEY = 'MSG_RECORD_';
    const PREFIX_USERNAME = 'USER_NAME_';

    public function __construct()
    {
        $this->redis = new RedisApi();
    }

    /**
     * 生成msgid 全局唯一
     */
    public function GenMsgID()
    {
        return $this->redis->Incr(self::MSG_KEY);
    }

    /**
     * 增加信息
     */
    public function AddMsg($username, $content)
    {
        // 构造一个消息体:
        // 消息体标识: $msgKey
        // 消息发布者姓名: $username
        // 消息发布者姓名加密: $md5Username
        // 消息体内容: $content
        // 消息体创建时间: $ctime

        // 1 获取一个msgid
        $msgId = $this->GenMsgID();
        $ctime = time();
        $msgKey = self::PREFIX_MSG_BODY_KEY . $msgId;
        $md5Username = md5($username);
        // 2 插入数据
        $this->redis->HSet($msgKey, 'username_md5', $md5Username);
        $this->redis->HSet($msgKey, 'username', $username);
        $this->redis->HSet($msgKey, 'content', $content);
        $this->redis->HSet($msgKey, 'ctime', $ctime);
        return true;
    }

    /**
     * 获取所有消息
     */
    public function GetAllMsg()
    {
        // 1 获取所有有效的key
        $msgBoyKeys = $this->redis->Keys(self::PREFIX_MSG_BODY_KEY . '*');
        $msgInfos = [];
        $i=0;
        foreach ($msgBoyKeys as $key=>$value){
            $msgInfos[$i] = $this->redis->HGetall($value);
            $msgInfos[$i]['MSG_RECORD'] = $msgBoyKeys[$i];
            $i++;
        }

        //尝试排序
        $sort = array(
            'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
            'field'     => 'MSG_RECORD',       //排序字段
        );
        $arrSort = array();
        foreach($msgInfos AS $uniqid => $row){
            foreach($row AS $key=>$value){
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if($sort['direction']){
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $msgInfos);
        }

        return $msgInfos;
    }

    /**
     * 删除消息
     */
    public function DeleteMsg($MSG_RECORD){
        $this->redis->Del($MSG_RECORD);
    }

    /**
     * 更改消息
     */
    public function UpdateMsg($MSG_RECORD,$username, $content){
        $this->redis->Update($MSG_RECORD,$username,$content);
    }

    /**
     * 获取一条消息
     */
    public function getOneMsg($MSG_RECORD){
        $msgInfos = $this->redis->HGetall($MSG_RECORD);
        $msgInfos['MSG_RECORD'] = $MSG_RECORD;
        return $msgInfos;
    }
}
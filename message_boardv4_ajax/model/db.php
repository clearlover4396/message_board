<?php

$mysqlLink = null;

$mysqlLink = db_connect('localhost', 'root', '', 'kingphp');

function db_connect($host, $user, $password, $database)
{
    $mysqlLink = mysqli_connect($host, $user, $password, $database);
    mysqli_query($mysqlLink, 'set names utf8');
    return $mysqlLink;
}

/**
 * 插入消息
 * @param $username 用户名
 * @param $content 消息内容
 * @return bool
 */
function add_msg($username, $content)
{
    $slqStrFormat = "insert into m_board(`user_name`, `content`, `ctime`) values('%s', '%s', %d)";

    $ctime = time();
    $sqlStr = sprintf($slqStrFormat, $username, $content, $ctime);

    global $mysqlLink;
    mysqli_query($mysqlLink, $sqlStr);

    return ['user_name'=>empty($username)?'匿名':$username,
            'content'=>$content,
            'ctime'=>date('Y-m-d H:i:m', $ctime)
    ];
}

/**
 * 查询所有内容
 */
function get_msgs()
{
    $strSql = 'select * from m_board';
    global $mysqlLink;
    $result = mysqli_query($mysqlLink, $strSql);

    $infos = [];
    $i = 0;
    while ($info = mysqli_fetch_assoc($result))
    {
        $infos[$i]['user_name'] = empty($info['user_name'])?'匿名': $info['user_name'];
        $infos[$i]['content'] = $info['content'];
        $infos[$i]['ctime'] = date('Y-m-d H:i:s',$info['ctime']);
        $i++;
    }
    return $infos;
}

/**
 * 查找一条消息
 */
function get_msg($m_id)
{
    $strSql = "select * from `m_board` where `m_id`=$m_id";
    global $mysqlLink;
    $result = mysqli_query($mysqlLink, $strSql);

    $info = mysqli_fetch_assoc($result);
    return $info;
}
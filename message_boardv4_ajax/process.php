<?php
/**
 * 留言板数据处理
 */

date_default_timezone_set('Asia/Shanghai');

// 返回的数据结构
/**
 * code : 返回码
 * msg : 返回的结果信息 与 code对应
 *      1: ok
 *      2: 消息内容为空 content not null
 * data: 返回的数据内容
 */
function rtMsg($code=1, $msg='ok', $data=[])
{
    $rtmsg['code'] = $code;
    $rtmsg['msg'] = $msg;
    $rtmsg['data'] = $data;

    echo json_encode($rtmsg);
    return;
}

if(empty($_POST['content'])) {
    return rtMsg(2, 'content not null');
}

$username = empty($_POST['username'])?'':$_POST['username'];
$content = $_POST['content'];

include_once 'model/db.php';

$info = add_msg($username, $content);

rtMsg(1, 'ok', $info);



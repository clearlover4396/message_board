<?php
header("Content-type:text/html;charset=utf-8");
include_once "MsgBoard.php";

$function = $_GET['f'];
$function();

//添加数据
function addMsg(){
    $username = $_GET['username'];
    $content = $_GET['content'];

    $msgBoard = new MsgBoard();
    $msgBoard->AddMsg($username, $content);
    header("location:http://localhost/redis/index.php?f=getMsg");
}

//获取信息
function getMsg(){
    $msgBoard = new MsgBoard();
    $msgInfos=$msgBoard->GetAllMsg();
    $GLOBALS['msgInfos'] = $msgInfos;
   include "msgIndex.php";
}

//删除信息
function delMsg(){
    $MSG_RECORD=$_GET['MSG_RECORD'];
    $msgBoard = new MsgBoard();
    $msgBoard->DeleteMsg($MSG_RECORD);
    header("location:http://localhost/redis/index.php?f=getMsg");
}

//更新信息
function updatMsg(){
    $MSG_RECORD=$_GET['MSG_RECORD'];
    $username = $_GET['username'];
    $content = $_GET['content'];

    $msgBoard = new MsgBoard();
    $msgBoard->UpdateMsg($MSG_RECORD,$username,$content);
    header("location:http://localhost/redis/index.php?f=getMsg");
}

//更新页面信息
function getOneMsg(){
    $MSG_RECORD=$_GET['MSG_RECORD'];
    $msgBoard = new MsgBoard();
    $msgInfos = $msgBoard->getOneMsg($MSG_RECORD);
    $GLOBALS['msgInfos'] = $msgInfos;
    include "update.php";
}

//addMsg();         //http://localhost/redis/index.php?username=ll&content=llll
//getMsg();        //http://localhost/redis/index.php
//delMsg();       //http://localhost/redis/index.php?MSG_RECORD=MSG_RECORD_7
//updatMsg();   //http://localhost/redis/index.php?MSG_RECORD=MSG_RECORD_4&username=kk&content=kkkkkkkkkkkkk





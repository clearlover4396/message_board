<?php
include_once 'model/db.php';

$infos = get_msgs();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>匿名留言</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            font-size: 15px;
            font-family: '微软雅黑';
            color: #666666;
        }
        .container {
            width: 600px;
            margin: 10px auto;
            //border: solid 1px rgba(189, 189, 189, 0.35);
            box-sizing: border-box;

        }
        .header {
            padding: 20px 0;
            font-size: 2em;
            text-align: center;
            letter-spacing: 2em;
            background-color: #060d1d;
            color: white;
        }
        .messsages {
            margin: 20px 0;
        }

        .message {
            border-bottom: 1px solid #d6d6d6;
            margin-bottom: 15px;
        }
        .username {
            font-size: 14px;
        }
        .content {
            margin: 20px 0px 10px 40px;
        }
        .content {
            font-size: 16px;
        }
        .ctime {
            text-align: right;
            color: #989898;
            font-size: 14px;
        }
        .reply {
            box-sizing: border-box;
        }
        .lebel {
            width: 10%;
            display: inline-block;
        }
        .item {
            margin: 15px 0;
        }
        .item input, .item textarea {
            width: 85%;
            display: inline-block;
        }
        .item input {
            padding: 5px;
        }
        .item textarea {
            vertical-align: text-top;
        }
        .header {
            box-shadow: 0 1px 9px #060d1d;
        }
        .footer {
            background-color: #060f2b;
            margin-top: 10px;
            padding: 40px 0;
            //border-top: solid 1px #d6d6d6;
            box-shadow: 0 -1px 9px #060d1d;
        }
        .copyright {
            text-align: center;
            //margin: 20px 0;
        }

        .alert-cover {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(188, 188, 188, 0.5);
        }
        .alert {
            width: 400px;
            border: solid 1px #330066;
            margin: 0 auto;
            background-color: #d1d1d1;
            box-shadow: 0px 3px 9px #330066;
            position: absolute;
            opacity: 1;
            top: 30%;
            left: 30%;
            z-index: 901;
        }
        .alert-head, .alert-btn {
            background-color: #330066;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding: 2px 10px;
            color: #bcbcbc;
        }
        .alert-msg {
            padding: 10px 10px;
        }
        .btn {
            border: solid 1px rgba(209, 209, 209, 0.43);
            padding: 5px 15px;
            border-radius: 5px;
            background-color: rgba(28, 0, 58, 0.74);
            color: #bcbcbc;
        }
        .btn:active {
            box-shadow: 2px 2px rgba(97, 97, 97, 0.69);
        }

        .hidden {
            display: none;
        }

    </style>
</head>
<body>
<div class="header">留言板</div>
<div class="container">
    <div class="messsages">
        <?php foreach ($infos as $info): ?>
        <div class="message">
            <div class="username"><?php echo $info['user_name']; ?></div>
            <div class="content"><?php echo $info['content']; ?></div>
            <div class="ctime"><?php echo $info['ctime']; ?></div  >
        </div>
        <?php endforeach;?>

    </div>
    <div class="reply">
        <form action="process.php" method="post">
            <div class="item">
                <div class="lebel">姓名</div>
                <input type="text" id="username" name="username">
            </div>
            <div class="item">
                <div class="lebel">内容</div>
                <textarea rows="15" name="content" id="content"></textarea>
            </div>
            <div class="item">
                <div class="lebel"></div>
                <input type="button" value="提交" onclick="addMsg();">
            </div>
        </form>
    </div>
</div>
<div class="footer">
    <div class="copyright">
        KINGPHP @ copyright 2017-07
    </div>
</div>

<div class="alert-cover hidden">
    <div class="alert">
        <div class="alert-head">
            <div class="tips">提示</div>
            <div class="close" onclick="closeAlert();">x</div>
        </div>
        <div class="alert-msg">
            内容不能为空
        </div>
        <div class="alert-btn">
            <button class="btn" onclick="closeAlert();">确定</button>
            <div class="btn" onclick="closeAlert();">取消</div>
        </div>
    </div>
</div>

<script>
    function myAlert(msg) {
        var alert_cover = document.getElementsByClassName('alert-cover')[0];
        alert_cover.className = 'alert-cover';

        document.getElementsByClassName('alert-msg')[0].innerText = msg;
    }

    function closeAlert() {
        var alert_cover = document.getElementsByClassName('alert-cover')[0];
        alert_cover.className = 'alert-cover hidden';
    }
</script>

<script>
    <?php if(!empty($_GET['errmsg'])): ?>
    myAlert('<?php echo $_GET["errmsg"]; ?>');
    <?php endif;?>
</script>


<script>
    function addMsg() {

        var user_name = document.getElementById('username').value;
        var content = document.getElementById('content').value;

        var strData = "username="+user_name+"&content="+content;

        // 1 生成对象
        var xmlhttp;
        if(window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        }else { // ie6 ie5
            xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
        }
        /* 2 调用open,
         //          第一个参数为请求方式: get 或 post
         //          第二个参数为请求url地址，如果是get请求，把请求数据附加在这之后
         //          第三个参数为同步或异步方式, true为异步
         */
        xmlhttp.open('post','process.php',true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        // 3 发送请求
        xmlhttp.send(strData);

        // 4 异步接收服务器端返回来的数据
        xmlhttp.onreadystatechange = function () {
            /* readyState: ajax状态:
             //      0: ajax引擎未初始化
             //      1: ajax引擎正在加载
             //      2: Ajax引擎已加载，准备发送数据
             //      3: 与服务器交互中
             //      4: 与服务器交互完成
             // status: 服务器的响应的http协议中的状态码:
             //      200: ok
             //      404: 未找到页面
             //      500: 服务器错误
             //      ...
             */
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // 服务器正确响应,返回数据

                // 将json字符串转为js对象
                var info_obj = JSON.parse(xmlhttp.responseText);
                // 处理异常
                if(info_obj.code != 1) {
                    switch (info_obj.code)
                    {
                        case 2: myAlert('内容不能为空');return;
                    }
                }

                // 显示数据
                var messsages = document.getElementsByClassName('messsages')[0];

                var username_div = document.createElement('div');
                username_div.className = 'username';
                var node_text = document.createTextNode(info_obj.data.user_name);
                username_div.appendChild(node_text);

                var content_div = document.createElement('div');
                content_div.className = 'content';
                node_text = document.createTextNode(info_obj.data.content);
                content_div.appendChild(node_text);

                var ctime_div = document.createElement('div');
                ctime_div.className = 'ctime';
                node_text = document.createTextNode(info_obj.data.ctime);
                ctime_div.appendChild(node_text);

                var message_div = document.createElement('div');
                message_div.className = 'message';

                message_div.appendChild(username_div);
                message_div.appendChild(content_div);
                message_div.appendChild(ctime_div);

                var messsages_div = document.getElementsByClassName('messsages')[0];
                messsages_div.appendChild(message_div);

                myAlert('提交成功');
            }
        }
    }


</script>


</body>
</html>
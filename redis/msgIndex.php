<?php $msgInfos = $GLOBALS['msgInfos'];  ?>
<!DOCTYPE html>
<html>
<head>
    <title>留言板</title>
    <style>
        *{
            margin: 0px;
            padding:0px;
        }
        body{
            font-size: 15px;
        }

        .container{
            width: 600px;
            margin: 50px auto;
        }

        .nav{
            text-align: center;
        }

        .form-item{
            margin: 12px 0px;
        }

        .form-item label{
            display: inline-block;
            width: 10%;
        }

        .form-item input{
            width: 80%;
            line-height: 2em;
        }

        .content{
            margin-top: 50px;
            border-top: dashed 5px deepskyblue;
        }

        .content-item{
            margin: 20px 5px;
        }
        .content-item .name{
            margin: 5px;
            color: red;
        }
        .content-item .msg-content{
            padding: 5px;
            margin: 10px 3px;
            text-indent:20px;
        }

        .content-item .ctime{
            text-align: right;
            font-style: italic;
        }
        .content-item .delete{
            float: right;
            color: red;
        }

        .button{
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="nav">
        <h1>留言板</h1>
    </div>

    <div class="msg-board">
        <form action="" method="get">
            <input name="f" value="addMsg" hidden="hidden">
            <div class="form-item">
                <label>姓名</label>
                <input type="text" name="username" style="border: solid 10px skyblue">
            </div>
            <div class="form-item">
                <label style="vertical-align: top">内容</label>
                <textarea name="content" rows="10" cols="66" style="border: solid 10px skyblue"></textarea>
            </div>
            <div class="form-item">
                <label></label>
                <input type="submit" class="button">
            </div>
        </form>
    </div>

    <div class="content">
        <form action="" method="get">
            <?php foreach ($msgInfos as $info):?>
                <div class="content-item">
                    <div class="delete"><a href="?f=getOneMsg&MSG_RECORD=<?php echo $info['MSG_RECORD'];?>">更改</a>&nbsp;<a href="?f=delMsg&MSG_RECORD=<?php echo $info['MSG_RECORD'];?>">删除</a></div>
                    <div class="name" ><?= $info['username'] ?></div>
                    <div class="msg-content"><?php echo $info['content'];?></div>
                    <div class="ctime"><?php echo date('Y-m-d H:i:s',$info['ctime']);?></div>

                    <hr>
                </div>
            <?php endforeach;?>
        </form>
    </div>
</div>

</body>
</html>
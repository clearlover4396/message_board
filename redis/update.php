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
            margin: 0px auto;
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
            padding-top: 20px;
        }

        .content-item{
            margin: 20px 5px;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="nav">
        <h1>留言板</h1>
    </div>

    <div class="msg-board">
        <form action="http://localhost/redis/index.php?f=aadMsg" method="get">
            <input name="f" value="updatMsg" hidden="hidden">
            <div class="form-item">
                <input name="MSG_RECORD" type="text" value="<?php echo $msgInfos['MSG_RECORD']; ?>" hidden>
                <label>姓名</label>
                <input type="text" name="username" value="<?php echo $msgInfos['username']; ?>">
            </div>
            <div class="form-item">
                <label>内容</label>
                <textarea name="content" rows="10" cols="66"><?php echo $msgInfos['content']; ?></textarea>
            </div>
            <div class="form-item">
                <label></label>
                <input type="submit" class="submit">
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>勤怠管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./design/style.css">
</head>
<body>
    <div>
        <h1>出勤時間と退勤時間をただ記録するだけ</h1>
        <p id="realTime"></p>

        <form action="./post.php" method="post">
            <button id="go" class="btn" name="action" value="go">出勤</button>
            <p>or</p>
            <button id="back" class="btn" name="action" value="back">退勤</button>
        </form>
        <h2><?php echo !empty($_SESSION["go"]) ? "あなたは" . $_SESSION["go"] . "に出勤しました。" : "" ;?></h2>
        <h2><?php echo !empty($_SESSION["back"]) ? "あなたは" . $_SESSION["back"] . "に退勤しました。" : "" ;?></h2>
        <p><a href="./list.php">週・月別リストへ</a></p>
        <p><a href="./update.php">時間修正・削除</a></p>

        <?php
            $_SESSION = array();
            session_destroy();
        ?>
    </div>
    <script>
        function realTimer() {
            const date = new Date();
            const time = date.toLocaleString();
            var hour = date.getHours();
            var minutes = date.getMinutes();
            if(hour < 10) {
                hour = "0" + hour;
            }
            if(minutes < 10) {
                minutes = "0" + minutes;
            }

            document.getElementById("realTime").textContent = time;
            setTimeout(realTimer, 1000);
        }
        window.onload = realTimer;
    </script>
</body>
</html>

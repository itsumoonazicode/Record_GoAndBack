
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>勤怠管理 - 修正・削除</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./design/style.css" />
</head>
<body>

<?php

require "config.php";

$connection = new PDO($dsn, $username, $password, $options);

try {
$sqlGo = <<<EOT
SELECT
goDate,
SUBSTRING(goDate, 1, 10) AS YMD,
SUBSTRING(goDate, 12, 5) AS HM,
id
FROM rctime
WHERE goDate > 0
EOT;
    
    $statement = $connection->prepare($sqlGo);
    $statement->execute();
    
    $result = $statement->fetchAll();
    
    
$sqlBack = <<<EOT
SELECT
backDate
FROM rctime
WHERE backDate > 0
EOT;
    
    $state = $connection->prepare($sqlBack);
    $state->execute();
    
    $res = $state->fetchAll();
    
    
    } catch(PDOException $error) {
        echo $error->getMessage();
    }
?> 
<?php
    if($result && $statement->rowCount() > 0) {
        echo "出社時間" . nl2br(PHP_EOL);
        
        foreach($result as $row) {
            echo $row["YMD"];
?>
            <input type="time" class="timeYM" id="<?php echo $row["id"];?>" name="HM" value="<?php echo $row["HM"];?>">
            <br>
<?php
        }
?>
        <p>
        <button id="upd_btn" class="btn__small" name="upd">更新</button>
        <button id="dlt_btn" class="btn__small" name="dlt">削除</button>
        </p>

<?php
    } else {
        echo "No results found.";
    }
    if($res && $state->rowCount() > 0) {
        echo "退社時間" . nl2br(PHP_EOL);
        foreach($res as $r) {
            echo $r["backDate"] . nl2br(PHP_EOL);
        }
    } else {
        echo "No results found.";
    }
?>

    <p><a href="./index.php">トップページへ戻る</a></p>
    <p><a href="./list.php">月・週別リストへ</a></p>
    <script>
        const time = document.getElementsByClassName('timeYM');
        const ev_btn = document.getElementById('upd_btn');

        for(let i = 0; i < time.length; i++) {
            time[i].addEventListener('blur', (event) => {
                let ev_val = event.target.value;
                let ev_id = event.target.id;
                console.log(event.target.value);
                console.log(event.target.id);
                fetch('./update_time.php', {
                    method: 'POST',
                    headers: new Headers( {'Content-type' : 'application/json'} ),
                    body: JSON.stringify({id: ev_id, val: ev_val})
                }).then((res) => res.text())
                .then((data) => console.log(data))
                .catch((err) => console.log(err))
            });
        }
    </script>
</body>
</html>

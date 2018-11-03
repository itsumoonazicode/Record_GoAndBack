<?php
require "config.php";

$connection = new PDO($dsn, $username, $password, $options);


$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if($contentType === "application/json") {
    $content = trim(file_get_contents("php://input"));

    $decode = json_decode($content, true);

    if(!is_array($decode)) {
        echo "error: json_decode";
    } else {
        echo "success: json_decode" . PHP_EOL;
        var_dump($decode["val"]);
        var_dump($decode["id"]);
        try {
            
// SELECT文
$select_go_sql = <<<EOT
SELECT
SUBSTRING(goDate, 1, 10) AS YMD,
SUBSTRING(goDate, 17, 3) AS MM
FROM
rcTime
WHERE id = {$decode["id"]}
EOT;
                    
                $statement = $connection->prepare($select_go_sql);
                $statement->execute();
                
                $result = $statement->fetchAll();
            
            } catch(PDOException $error) {
                echo $select_go_sql . PHP_EOL . $error->getMessage();
            }

        if($result && $statement->rowCount() > 0) {
            foreach($result as $res) {
                $ymd = $res["YMD"];
                $mm = $res["MM"];
            }
            try {

//UPDATE文
$upd_go_sql = <<<EOT
UPDATE rctime
SET goDate = '$ymd {$decode["val"]}$mm'
WHERE id = {$decode["id"]}
EOT;


                    $statement = $connection->prepare($upd_go_sql);
                    $statement->execute();

                    $result = $statement->fetchAll();

                } catch(PDOException $error) {
                    echo $upd_go_sql . PHP_EOL . $error->getMessage();
                }
                
        }
    }
}

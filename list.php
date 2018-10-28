<?php
require "config.php";

$connection = new PDO($dsn, $username, $password, $options);

try {

$sql = <<<EOT
SELECT
goDate
FROM rctime
WHERE goDate > 0
EOT;

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

if($result && $statement->rowCount() > 0) {
    foreach($result as $row) {
        echo $row["goDate"] . nl2br(PHP_EOL);
    }
} else {
    echo "No results found.";
}

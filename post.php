<?php
session_start();
date_default_timezone_set('Asia/Tokyo');


$timestamp = $_SERVER['REQUEST_TIME'];
$record_time = date("Y-m-d H:i:s", $timestamp);
 

if($_POST['action'] === "go") {
    require "config.php";
    $_SESSION["go"] = $record_time;

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "INSERT INTO rctime (goDate) VALUES (:goDate)";
        $statement = $connection->prepare($sql);
        $statement->execute(array("goDate" => $record_time));
    
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

} else {
    require "config.php";
    $_SESSION["back"] = $record_time;

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "INSERT INTO rctime (backDate) VALUES (:backDate)";
        $statement = $connection->prepare($sql);
        $statement->execute(array("backDate" => $record_time));

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

}
header('Location: ' . './index.php');

exit;

<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
$timestamp = $_SERVER['REQUEST_TIME'];
$record_time = date("Y/m/d H時i分", $timestamp);

if($_POST['action'] === "go") {
    $_SESSION["go"] = $record_time;
} else {
    $_SESSION["back"] = $record_time;
}
header('Location: ' . './index.php');

exit;

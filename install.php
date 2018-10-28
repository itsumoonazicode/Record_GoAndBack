<?php
/**
 * Create Database and table
 * 
 */

require "config.php";

$connection = new PDO("mysql:host=$host", $username, $password, $options);
$sql = file_get_contents("./init.sql");

try {
    // code to execute
    $connection->exec($sql);

    echo "Database and table users created successfully.";

} catch(PDOException $error) {
    // exeption
    echo $sql . "<br>" . $error->getMessage();
}


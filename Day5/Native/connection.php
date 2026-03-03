<?php

session_start();



$dbType = "mysql";
$dbName = "iti_os_46_2026";
$host = "localhost";
$userName = "root";
$password = "";

try {
    $connection = new PDO("$dbType:host=$host;dbname=$dbName", $userName, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->exec(
        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    );

    if (basename($_SERVER['PHP_SELF']) === 'connection.php') {
        require "navbar.php";
        echo "<h1 class='test-success text-center mt-5'>connection With Database</h1>";
        echo "<h1 class='text-success text-center mt-5'>Connection Success</h1>", $connection->getAttribute(PDO::ATTR_CONNECTION_STATUS);
    }
} catch (PDOException $e) {

    echo $e->getMessage();
}

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

$createTableSQL = "CREATE TABLE IF NOT EXISTS messages (
    msg_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    msg_text TEXT NOT NULL
)";
$conn->query($createTableSQL);

$conn->close();
?>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST["fullName"];
    $message = $_POST["message"];

    // Экранируем данные, чтобы избежать SQL-инъекций
    $fullName = $conn->real_escape_string($fullName);
    $message = $conn->real_escape_string($message);

    $createTableSQL = "CREATE TABLE IF NOT EXISTS messages (
        msg_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_name VARCHAR(255) NOT NULL,
        msg_text TEXT NOT NULL
    )";
    $conn->query($createTableSQL);

    $insertSQL = "INSERT INTO messages (user_name, msg_text) VALUES ('$fullName', '$message')";
    $conn->query($insertSQL);
}

$selectSQL = "SELECT user_name, msg_text FROM messages";
$result = $conn->query($selectSQL);

// Формируем массив с результатами
$messages = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = array(
            "user_name" => $row["user_name"],
            "msg_text" => $row["msg_text"]
        );
    }
}

$conn->close();

// Возвращаем результат в формате JSON
header("Content-Type: application/json");
echo json_encode($messages);
?>

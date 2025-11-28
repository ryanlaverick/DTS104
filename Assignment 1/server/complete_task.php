<?php

include 'dbconnect.php';

session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $taskId = $_GET['id'];
        $completedBy = $_SESSION['id'];
        $completedAt = date('Y-m-d H:i:s');

        $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $updateQuery = $connection->prepare("UPDATE $requestsTable SET completed_by = :completed_by, completed_at = :completed_at WHERE id = :id");
        $updateQuery->bindParam(':completed_by', $completedBy);
        $updateQuery->bindParam(':completed_at', $completedAt);
        $updateQuery->bindParam('id', $taskId);

        $updateQuery->execute();
    } else {
        echo "You are here by mistake";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}


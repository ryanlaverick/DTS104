<?php

include 'dbconnect.php';

session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email = $_POST['email'];
        $password = $_POST['password'];
        $userType = 'user';

        $loginQuery = $conn->prepare("SELECT * FROM $usersTable WHERE email = :email AND password = :password");
        $loginQuery->bindParam(':email', $email);
        $loginQuery->bindParam(':password', $password);
        $loginQuery->execute();

        if ($loginQuery->rowCount()) {
            $row = $loginQuery->fetch();

            $_SESSION['loggedIn'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['userType'] = $row['user_type'];

            if ($row['user_type'] === 'admin') {
                header("Location: ../admin_portal.php");
            } else {
                header("Location: ../report_issue.php");
            }
        } else {
            echo "Invalid credentials";
        }
    } else {
        echo "You are here by mistake";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
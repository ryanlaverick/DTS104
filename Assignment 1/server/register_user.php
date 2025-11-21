<?php
session_start();

include 'dbconnect.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email = $_POST['email'];
        $password = $_POST['password'];
        $userType = 'user';

        /*
         * Ensure that more than one account with the same email can be created
        */
        $existenceQuery = $conn->prepare("SELECT 1 FROM $usersTable WHERE email = :email");
        $existenceQuery->bindParam(':email', $email);
        $existenceQuery->execute();

        if ($existenceQuery->fetch(PDO::FETCH_COLUMN)) {
            echo "An account with this email already exists!";
            return;
        }

        $registerQuery = $conn->prepare("INSERT INTO $usersTable (email, password, user_type) VALUES (:email, :password, :userType)");
        $registerQuery->bindParam('email', $email);
        $registerQuery->bindParam('password', $password);
        $registerQuery->bindParam('userType', $userType);
        $registerQuery->execute();

        $_SESSION['loggedIn'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['userType'] = $userType;

        header("Location: ../view_tasks.php");
    } else {
        echo "You are here by mistake";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
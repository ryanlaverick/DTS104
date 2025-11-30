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

        $loginQuery = $conn->prepare("SELECT * FROM northview_hospital_users WHERE email = :email AND password = :password");
        $loginQuery->bindParam(':email', $email);
        $loginQuery->bindParam(':password', $password);
        $loginQuery->execute();

        if ($loginQuery->rowCount()) {
            $row = $loginQuery->fetch();

            $_SESSION['loggedIn'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['userType'] = $row['user_type'];

            switch ($row['user_type']) {
                case 'admin':
                    header("Location: ../admin_portal.php");
                    break;
                default:
                case 'user':
                    header("Location: ../report_issue.php");
            }
        } else {
            $_SESSION['loginErrors'] = ['Invalid credentials! Please try again'];

            header('Location: ../index.php');
        }

    } else {
        echo "You are here by mistake";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
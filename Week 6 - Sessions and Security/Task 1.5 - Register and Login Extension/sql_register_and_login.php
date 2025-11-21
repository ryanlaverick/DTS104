<?php
session_start();

include 'dbconnect.php';

try {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
                
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $user_type = 'user';

        $existenceQuery = $conn->prepare("SELECT 1 FROM users WHERE email = :email");
        $existenceQuery->bindParam(':email', $user_email);
        $existenceQuery->execute();

        if ($existenceQuery->fetch(PDO::FETCH_COLUMN)) {
            echo "An account with this email has already been created!";
            return;
        }

        $registerQuery = $conn->prepare("INSERT INTO users (email, password, user_type) VALUES (:email, :password, :user_type)");
        $registerQuery->bindParam(':email', $user_email);
        $registerQuery->bindParam(':password', $user_password);
        $registerQuery->bindParam(':user_type', $user_type);
        $registerQuery->execute();

        $_SESSION['login'] = 1;
        $_SESSION['email'] = $user_email;
        $_SESSION['user_type'] = $user_type;

        header("Location: account_area.php");
    } else {
        echo "You are here by mistake";
    }
} catch(PDOException $e) {
    echo $e->getMessage();  //If we are not successful in connecting or running the query we will see an error
}
?>
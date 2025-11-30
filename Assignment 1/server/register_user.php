<?php
session_start();

include 'dbconnect.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $userType = 'user';
        
        $emailErrors = validateEmail($email);
        $passwordErrors = validatePassword($password);

        if (count($emailErrors) > 0 || count($passwordErrors) > 0) {
            $_SESSION['emailErrors'] = $emailErrors;
            $_SESSION['passwordErrors'] = $passwordErrors;

            header('Location: ../register.php');

            exit;
        }

        $conn = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        header("Location: ../report_issue.php");
    } else {
        echo "You are here by mistake";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

function validateEmail(?string $email) {
    $emailErrors = [];

    if (! $email) {
        $emailErrors[] = 'Please provide an email address!';

        // Early return here prevents us encountering type errors when passing null to a function that expects a string
        return $emailErrors;
    }

    if (strlen($email) < 1 || strlen($email) > 255) {
        $emailErrors[] = 'Email cannot be longer than 255 characters!';
    }

    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErrors[] = 'Please provide a valid email address!';
    }

    return $emailErrors;
}

function validatePassword(?string $password) {
    $passwordErrors = [];

    if (! $password) {
        $passwordErrors[] = 'Please provide a valid password!';

        // Early return here prevents us encountering type errors when passing null to a function that expects a string
        return $passwordErrors;
    }

    if (strlen($password) > 255) {
        $passwordErrors[] = 'Password cannot be longer than 255 characters!';
    }

    return $passwordErrors;
}
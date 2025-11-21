<?php
session_start(); // important function to allow session variables  

if ($_SESSION['login'] != 1) {
    header("Location: login_form.html"); //send them to the form to login
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Viewing Account</title>

    <style>
        .updateButton {
            padding:5px;
            background-color:green;
            color:white;
            border-radius:3px;
            margin-top:3px;
            display:block;
            width:130px;
            text-decoration:none;
        }
        .logoutButton {
            padding:5px;
            background-color:red;
            color:white;
            border-radius:3px;
            margin-top:3px;
            display:block;
            width:130px;
            text-decoration:none;
        }
    </style>
</head>
<body>
    <a href="update_account.php" class="updateButton">Update Account</a>
    <br>
    <a href="logout.php" class="logoutButton">Logout</a>
</body>




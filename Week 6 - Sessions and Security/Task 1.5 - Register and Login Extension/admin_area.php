<?php
session_start(); // important function to allow session variables  

if ($_SESSION['login'] != 1 || $_SESSION['user_type'] != 'admin') {

    header("Location: login_form.html"); //send them to the form to login

}

echo "<p>Admin area</p>";
?>


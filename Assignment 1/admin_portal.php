<?php
session_start();

if (!$_SESSION['loggedIn']) {
    header("Location: index.php");
    return;
}

if ($_SESSION['userType'] != 'admin') {
    header("Location: report_issue.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Northview Hospital - Admin Portal</title>

        <link rel="stylesheet" href="assets/stylesheet.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css" rel="stylesheet">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>

    <body>
        <div id="logout">
            <form action="server/logout.php" method="POST">
                <button id="logout-button">Logout</button>
            </form>
        </div>

        <div id="vertical-container">
            <div class="card">
                <div class="tag-line">
                    <h2>Pending Tasks</h2>
                </div>

                <a href="pending_tasks.php">
                    <button class="form-button">View Pending Tasks</button>
                </a>
            </div>

            <div class="card">
                <h2>Completed Tasks</h2>

                <a href="completed_tasks.php">
                    <button class="form-button">View Completed Tasks</button>
                </a>
            </div>
        </div>
    </body>
</html>
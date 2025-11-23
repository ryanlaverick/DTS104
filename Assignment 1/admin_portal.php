<?php
session_start();

if (!$_SESSION['loggedIn']) {
    header("Location: index.html");
    return;
}

if ($_SESSION['userType'] != 'admin') {
    header("Location: report.html");
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
        <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>
    </head>

    <body>
        <div id="logout">
            <form action="server/logout.php" method="POST">
                <button id="logout-button">Logout</button>
            </form>
        </div>

        <div style="display: flex; flex-direction: column; justify-content: center; gap: 40px;">
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
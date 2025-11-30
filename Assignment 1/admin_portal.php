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

        <link rel="stylesheet" href="assets/stylesheet.css">
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
                <h2>Pending Tasks</h2>
                <p>Click here to view all pending requests that have not yet been completed!</p>
                <p>Tasks appearing in this list still require triaging and support.</p>

                <a href="pending_tasks.php" class="form-button" title="Redirect for viewing the Pending Tasks page">View Pending Tasks</a>
            </div>

            <div class="card">
                <h2>Completed Tasks</h2>

                <p>Click here to view all completed requests!</p>
                <p>Tasks appearing in this list have been dealt with and no longer require triaging or support.</p>

                <a href="completed_tasks.php" class="form-button" title="Redirect for viewing the Completed Tasks page">View Completed Tasks</a>
            </div>
        </div>
    </body>
</html>
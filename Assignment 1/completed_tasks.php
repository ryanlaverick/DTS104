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
        <title>Northview Hospital - Completed Tasks</title>

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
                 <a class="nav-link" href="admin_portal.php">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon-small"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 288 480 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-370.7 0 105.4-105.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
                    Back to Portal
                </a>

                <h1>
                <?php
                    include 'server/dbconnect.php';

                    try {
                        $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $countQuery = $connection->prepare("SELECT COUNT(*) FROM $requestsTable WHERE completed_at IS NOT NULL");
                        $countQuery->execute();

                        echo $countQuery->fetch(PDO::FETCH_COLUMN);

                    } catch(PDOException $e) {
                        echo "Error" . $e->getMessage();
                    }
                ?> Completed Tasks
                </h1>
            </div>

            <div id="card-scroll">
                 <?php
                    include 'server/dbconnect.php';

                    try {
                        $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $sqlQuery = "SELECT $requestsTable.*, $usersTable.email AS completed_by FROM $requestsTable LEFT JOIN $usersTable ON $requestsTable.id = $usersTable.id WHERE completed_at IS NOT NULL ORDER BY submitted_at DESC";

                        foreach ($connection->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
                            echo '<div class="card">';
                            echo '<h1>Department ' . $row['department'] .  ' - Room ' . $row['room_number'] . '</h1>';
                            echo '<h2> Equipment: ' . $row['equipment_type'] . '</h2>';
                            echo '<p>' . $row['short_descr'] .  '</p>';
                            echo '<h3>Submitted by ' . $row['submitted_by'] . ' at ' . $row['submitted_at'] . '</h3>';
                            echo '<h3>Completed by ' . $row['completed_by'] . ' at ' . $row['completed_at'] . '</h3>';
                            echo '</div>';
                        }
                    } catch(PDOException $e) {
                        echo "Error" . $e->getMessage();
                    }
                ?>
            </div>
        </div>
    </body>
</html>
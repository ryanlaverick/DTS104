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
        <title>Northview Hospital - Pending Tasks</title>

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
                <a class="nav-link" href="admin_portal.php" title="Redirect back to the Admin Portal page">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon-small"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 288 480 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-370.7 0 105.4-105.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
                    Back to Portal
                </a>

                <h1>
                <?php
                    include 'server/dbconnect.php';

                    try {
                        $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $countQuery = $connection->prepare("SELECT COUNT(*) FROM northview_hospital_maintenance_requests WHERE completed_at IS NULL");
                        $countQuery->execute();

                        echo $countQuery->fetch(PDO::FETCH_COLUMN);

                    } catch(PDOException $e) {
                        echo "Error" . $e->getMessage();
                    }
                ?> Pending Tasks
                </h1>
            </div>

            <div id="card-scroll">
                 <?php
                    include 'server/dbconnect.php';

                    try {
                        $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $sqlQuery = "SELECT * FROM northview_hospital_maintenance_requests WHERE completed_at IS NULL ORDER BY submitted_at DESC";

                        foreach ($connection->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
                            $actionString = 'server/complete_task.php?id='.$row['id'];

                            echo '<div class="card">';
                            echo '<h2>Department ' . $row['department'] .  ' - Room ' . $row['room_number'] . '</h2>';
                            echo '<h3> Equipment: ' . $row['equipment_type'] . '</h3>';
                            echo '<p>' . $row['short_descr'] .  '</p>';
                            echo '<br><br>';
                            echo '<div id="card-info">';
                            echo '<p class="whisper-text">Submitted by ' . $row['submitted_by'] . ' at ' . $row['submitted_at'] . '</p>';
                            echo '</div>';
                            echo '<form action="'.$actionString.'" method="post" onsubmit="return confirm(\'Are you sure you want to complete this task?\');">';
                            echo '<input type="submit" class="form-button" value="Complete Task">';
                            echo '</form>';
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
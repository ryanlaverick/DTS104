<?php
session_start();

if (!$_SESSION['loggedIn']) {
    header("Location: index.html");
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

        <link rel="stylesheet" href="assets/stylesheet.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>
    </head>

    <body>
        <div id="vertical-column">
            <div class="card">
                <h1>
                <?php
                    include 'server/dbconnect.php';

                    try {
                        $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $countQuery = $connection->prepare("SELECT COUNT(*) FROM $requestsTable WHERE completed_at IS NULL");
                        $countQuery->execute();

                        echo $countQuery->fetch(PDO::FETCH_COLUMN);

                    } catch(PDOException $e) {
                        echo "Error" . $e->getMessage();
                    }
                ?> Pending Tasks
                </h1>
            </div>

            <?php
                include 'server/dbconnect.php';

                try {
                    $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sqlQuery = "SELECT * FROM $requestsTable WHERE completed_at IS NULL ORDER BY submitted_at DESC";

                    foreach ($connection->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
                        echo '<div class="card">';
                        echo '<h2>Department ' . $row['department'] .  ' - Room ' . $row['room_number'] . '</h2>';
                        echo '<h3> Equipment: ' . $row['equipment_type'] . '</h3>';
                        echo '<p>' . $row['short_descr'] .  '</p>';
                        echo '<h4>Submitted by ' . $row['submitted_by'] . ' at ' . $row['submitted_at'] . '</h4>';
                        echo '<br><br>';
                        echo '<button class="form-button">Complete Task</button>';
                        echo '</div>';
                    }
                } catch(PDOException $e) {
                    echo "Error" . $e->getMessage();
                }
            ?>
        </div>
    </body>
</html>
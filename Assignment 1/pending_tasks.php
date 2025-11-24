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
        <div class="form">
            <h1>Pending Tasks</h1>
            <table>
                <tr>
                    <th>Equipment Type</th>
                    <th>Issue</th>
                    <th>Department</th>
                    <th>Room Number</th>
                    <th>Reported At</th>
                </tr>

                <?php
                    include 'server/dbconnect.php';

                    try {
                        $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword);
                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $sqlQuery = "SELECT * FROM $requestsTable WHERE completed_at IS NULL ORDER BY submitted_at DESC";

                        foreach ($connection->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
                            echo "<tr>";
                            echo "<td>" . $row['equipment_type'] . "</td>";
                            echo "<td>" . $row['short_descr'] . "</td>";
                            echo "<td>" . $row['department'] . "</td>";
                            echo "<td>" . $row['room_number'] . "</td>";
                            echo "<td>" . $row['reported_at'] . "</td>";
                            echo "</tr>";
                        }
                    } catch(PDOException $e) {
                        echo "Error" . $e->getMessage(); //If we are not successful we will see an error
                    }
                ?>
            </table>
        </div>
    </body>
</html>
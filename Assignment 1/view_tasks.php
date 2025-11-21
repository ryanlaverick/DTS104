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
        <title>View Tasks</title>

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

        <div class="form">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Submitted By</th>
                    <th>Issue</th>
                    <th>Equipment Type</th>
                    <th>Room Number</th>
                    <th>Department</th>
                    <th>Completed</th>
                    <th>Completed At</th>
                    <th>Completed By</th>
                </tr>

                <?php
                    include 'server/dbconnect.php';

                    try {
                        $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword); //building a new PDO connection object
                        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception

                        $sql = "SELECT * FROM $requestsTable ORDER BY id ASC";

                        //For each result that we return, loop through the result and perform the echo statements.
                        //Data will be formatted into a table
                        //$row is an array with the fields for each record returned from the SELECT
                        foreach($connection->query($sql, PDO::FETCH_ASSOC) as $row){
                            echo '<tr>';
                            echo '<td>'. $row['id'] . '</td>';
                            echo '<td>'. $row['submitted_by'] . '</td>';
                            echo '<td>'. $row['short_descr'] . '</td>';
                            echo '<td>'. $row['equipment_type'] . '</td>';
                            echo '<td>'. $row['room_number'] . '</td>';
                            echo '<td>'. $row['department'] . '</td>';
                            echo '<td>'. $row['completed'] . '</td>';
                            echo '<td>'. $row['completed_at'] . '</td>';
                            echo '<td>'. $row['completed_by'] . '</td>';

                            echo '</tr>';
                        }

                    } catch (PDOException $e) {
                        echo $e->getMessage(), $e->getTraceAsString();
                    }
                ?>
            </table>
        </div>
    </body>
</html>
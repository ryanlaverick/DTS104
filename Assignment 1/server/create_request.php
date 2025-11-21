<?php
include 'dbconnect.php';

$submitted_by = "ryan.laverick03@hotmail.co.uk"; // TODO: Change this to pull from session once logged in
$short_descr = $_POST['short_descr'];
$equipment_type = $_POST['equipment_type'];
$department = $_POST['department'];
$room_number = $_POST['room_number'];

try {
    $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword); //building a new PDO connection object
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception

    $statement = $connection->prepare("INSERT INTO $requestsTable (submitted_by, short_descr, equipment_type, room_number, department)
    VALUES (:submitted_by, :short_descr, :equipment_type, :room_number, :department)");

    $statement->bindParam(':submitted_by', $submitted_by);
    $statement->bindParam(':short_descr', $short_descr);
    $statement->bindParam(':equipment_type', $equipment_type);
    $statement->bindParam(':room_number', $room_number);
    $statement->bindParam(':department', $department);

    $statement->execute();

    echo "Request Submitted!";
} catch (PDOException $e) {
    echo $e->getMessage(), $e->getTraceAsString();
}

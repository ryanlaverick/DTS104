<?php
include 'dbconnect.php';

session_start();

try {
    $submittedBy = $_POST['email'];
    $shortDescr = $_POST['short_descr'];
    $equipmentType = $_POST['equipment_type'];
    $department = $_POST['department'];
    $roomNumber = $_POST['room_number'];

    $shortDescriptionErrors = validateDescription($shortDescr);
    $equipmentTypeErrors = validateEquipmentType($equipmentType);
    $departmentErrors = validateDepartment($department);
    $roomNumberErrors = validateRoomNumber($roomNumber);

    if (
        count($shortDescriptionErrors) > 0 
        || count($equipmentTypeErrors) > 0
        || count($departmentErrors) > 0
        || count($roomNumberErrors) > 0
    ) {
        $_SESSION['descriptionErrors'] = $shortDescriptionErrors;
        $_SESSION['equipmentTypeErrors'] = $equipmentTypeErrors;
        $_SESSION['departmentErrors'] = $departmentErrors;
        $_SESSION['roomNumberErrors'] = $roomNumberErrors;
        

        header('Location: ../report_issue.php');

        exit;
    }

    $connection = new PDO("mysql:host=$serverName;dbname=$database", $dbUsername, $dbPassword); //building a new PDO connection object
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception

    $statement = $connection->prepare("INSERT INTO northview_hospital_maintenance_requests (submitted_by, short_descr, equipment_type, room_number, department, submitted_at)
    VALUES (:submitted_by, :short_descr, :equipment_type, :room_number, :department, :submitted_at)");

    $statement->bindParam(':submitted_by', $submittedBy);
    $statement->bindParam(':short_descr', $shortDescr);
    $statement->bindParam(':equipment_type', $equipmentType);
    $statement->bindParam(':room_number', $roomNumber);
    $statement->bindParam(':department', $department);
    $statement->bindParam(':submitted_at', date('Y-m-d H:i:s'));

    $statement->execute();

    echo "Request Submitted!";
} catch (PDOException $e) {
    echo $e->getMessage(), $e->getTraceAsString();
}

function validateDescription(?string $description) {
    $descriptionErrors = [];

    if (! $description || $description == '') {
        $descriptionErrors[] = 'Please provide a description of your issue!';

        // Early return here prevents us encountering type errors when passing null to a function that expects a string
        return $descriptionErrors;
    }

    if (strlen($description) > 150) {
        $descriptionErrors[] = 'Description cannot be longer than 150 characters!';
    }

    return $descriptionErrors;
}

function validateEquipmentType(?string $equipmentType) {
    $equipmentTypeErrors = [];

    if (! $equipmentType || $equipmentType == '') {
        $equipmentTypeErrors[] = 'Please provide the equipment type!';

        // Early return here prevents us encountering type errors when passing null to a function that expects a string
        return $equipmentTypeErrors;
    }

    if (strlen($equipmentType) > 50) {
        $equipmentTypeErrors[] = 'Equipment type cannot be longer than 50 characters!';
    }

    return $equipmentTypeErrors;
}

function validateDepartment(?string $department) {
    $departmentErrors = [];

    if (! $department || $department == '') {
        $departmentErrors[] = 'Please provide a department!';

        // Early return here prevents us encountering type errors when passing null to a function that expects a string
        return $departmentErrors;
    }

    if (strlen($department) > 50) {
        $departmentErrors[] = 'Department cannot be longer than 50 characters!';
    }

    return $departmentErrors;
}

function validateRoomNumber(?string $roomNumber) {
    $roomNumberErrors = [];

    if (! $roomNumber) {
        $roomNumberErrors[] = 'Please provide a room number!';

        // Early return here prevents us encountering type errors when passing null to a function that expects a string
        return $roomNumberErrors;
    }

    if (! is_numeric($roomNumber)) {
        $roomNumberErrors[] = 'Please provide a numeric room number!';
    }

    return $roomNumberErrors;
}
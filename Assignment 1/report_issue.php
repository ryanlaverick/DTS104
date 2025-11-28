<?php
session_start();

$email = $_SESSION['email'];

if (!$_SESSION['loggedIn']) {
    header("Location: index.html");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Request Support</title>

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

        <form action="server/create_request.php" method="post" class="form">
            <h1>Request Support</h1>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="<?= $email; ?>" readonly="true" />
            </div>

            <div class="form-group">
                <label for="equipment_type">Equipment Type</label>
                <input type="text" id="equipment_type" name="equipment_type" class="form-input" placeholder="Desktop PC" />
                <ul id="equipment-type-errors" class="form-errors"></ul>
            </div>

            <div class="form-group">
                <label for="short_descr">Description of the issue</label>
                <textarea type="text" id="short_descr" name="short_descr" class="form-input" placeholder="PC will not turn on, it is plugged in at the wall and all relevant cables are attached"></textarea>
                <ul id="short-descr-errors"></ul>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" id="department" name="department" class="form-input" placeholder="Radiology" />
                <ul id="department-errors" class="form-errors"></ul>
            </div>

            <div class="form-group">
                <label for="room_number">Room Number</label>
                <input type="text" id="room_number" name="room_number" class="form-input" placeholder="406" />
                <ul id="room-number-errors" class="form-errors"></ul>
            </div>

            <input type="submit" class="form-button" value="Submit Request" />
        </form>
    </body>
</html>
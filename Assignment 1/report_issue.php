<?php
session_start();

if (!$_SESSION['loggedIn']) {
    header("Location: index.php");
    return;
}

$email = $_SESSION['email'];
$equipmentTypeErrors = $_SESSION['equipmentTypeErrors'] ?? [];
$descriptionErrors = $_SESSION['descriptionErrors'] ?? [];
$departmentErrors = $_SESSION['departmentErrors'] ?? [];
$roomNumberErrors = $_SESSION['roomNumberErrors'] ?? [];

$hasSubmittedRequest = (bool) $_SESSION['requestSubmitted'];

unset($_SESSION['equipmentTypeErrors']);
unset($_SESSION['descriptionErrors']);
unset($_SESSION['departmentErrors']);
unset($_SESSION['roomNumberErrors']);
unset($_SESSION['requestSubmitted']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Request Support</title>

        <link rel="stylesheet" href="assets/stylesheet.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <script>
            function resetErrors() {
                document.getElementById('equipment-type-errors').innerHTML = ""
                document.getElementById('short-descr-errors').innerHTML = ""
                document.getElementById('department-errors').innerHTML = ""
                document.getElementById('room-number-errors').innerHTML = ""
            }

            function validate() {
                resetErrors()

                let hasErrors = false

                let equipmentType = document.getElementById('equipment_type').value
                if (! equipmentType || equipmentType == '') {
                    hasErrors = true
                    document.getElementById('equipment-type-errors').innerHTML += 'Please provide a valid equipment type!'
                }

                let shortDescription = document.getElementById('short_descr').value
                if (! shortDescription || shortDescription == '') {
                    hasErrors = true
                    document.getElementById('short-descr-errors').innerHTML += 'Please provide a valid description!'
                }

                let department = document.getElementById('department').value
                if (! department || department == '') {
                    hasErrors = true
                    document.getElementById('department-errors').innerHTML += 'Please provide a valid department!'
                }

                let roomNumber = document.getElementById('room_number').value
                if (! roomNumber || roomNumber == '') {
                    hasErrors = true
                    document.getElementById('room-number-errors').innerHTML += 'Please provide a valid room number!'
                }

                return !hasErrors
            }
        </script>
    </head>

    <body>
        <div id="logout">
            <form action="server/logout.php" method="POST">
                <button id="logout-button">Logout</button>
            </form>
        </div>

        <form action="server/create_request.php" method="post" onsubmit="return validate()" class="form">
            <h1>Request Support</h1>

            <?php
                if ($hasSubmittedRequest) {
                    echo '<div class="form-success">';
                    echo '<strong>Success!</strong> Your support ticket has been logged.';
                    echo '</div>';
                }
            ?>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="<?= $email; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="equipment_type">Equipment Type</label>
                <input type="text" id="equipment_type" name="equipment_type" class="form-input" placeholder="Desktop PC">
                <div id="equipment-type-errors" class="form-errors">
                    <?php
                        foreach ($equipmentTypeErrors as $error) {
                            echo $error . "<br>";
                        }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="short_descr">Description of the issue</label>
                <textarea id="short_descr" name="short_descr" class="form-input" placeholder="PC will not turn on, it is plugged in at the wall and all relevant cables are attached"></textarea>
                <div id="short-descr-errors" class="form-errors">
                    <?php
                        foreach ($descriptionErrors as $error) {
                            echo $error . "<br>";
                        }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" id="department" name="department" class="form-input" placeholder="Radiology">
                <div id="department-errors" class="form-errors">
                    <?php
                        foreach ($departmentErrors as $error) {
                            echo $error . "<br>";
                        }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="room_number">Room Number</label>
                <input type="text" id="room_number" name="room_number" class="form-input" placeholder="406">
                <div id="room-number-errors" class="form-errors">
                    <?php
                        foreach ($roomNumberErrors as $error) {
                            echo $error . "<br>";
                        }
                    ?>
                </div>
            </div>

            <input type="submit" class="form-button" value="Submit Request">
        </form>
    </body>
</html>
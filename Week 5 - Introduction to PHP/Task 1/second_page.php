<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passing Data To</title>
</head>

<body>
    <?php
		$firstName = $_GET['firstName'];
		$lastName = $_GET['lastName'];
	
		echo "Hello World, my name is $firstName $lastName";
	?>
</body>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passing Data From</title>
</head>

<body>
    <?php
		$firstName = "Ryan";
		$lastName = "Laverick";
	
		$url = "https://25dts104bj12yz.uoswebspace.co.uk/Week%205%20-%20Introduction%20to%20PHP/second_page.php?firstName=$firstName&lastName=$lastName";
	?>
	
	<a href="<?php echo $url ?>">Link to my second page</a>
</body>
<?php
    echo "This is an echo statement";
    print "This is a print statement";
	echo "<p>This is an echo statement wrapped in a paragraph tag</p>";

	$myStringVariable = "Hello Sunderland University";
	$myIntVariable = 2;
	$myBoolVariable = true;
	$myFloatVariable = 2.1;
	$myArrayVariable = ['Hello', 'Sunderland', 'University'];

	echo $myStringVariable . "<br/>";
	echo $myIntVariable . "<br/>";
	echo $myBoolVariable . "<br/>";
	echo $myFloatVariable . "<br/>";
	echo $myArrayVariable . "<br/>";
	echo join(' ', $myArrayVariable) . "<br/>";

	echo "<br/>";

	$hourlyRate = 5.60;
	$hoursWorked = 22;
	$pay = $hourlyRate * $hoursWorked;
	echo "Hourly Rate: " . $hourlyRate . "<br/>";
	echo "Number of Hours Worked: " . $hoursWorked . "<br/>";
	echo "Total Pay: " . $pay . "<br/>";
	
	echo "<br/>";
	
	$absenceHours = 5;
	echo "Time Off: " . $absenceHours . "<br/>";

	$overtimePay = 37.14;
	echo "Overtime Pay: " . $overtimePay . "<br/>"; 
	echo "Total Pay (inc. Overtime): " . ($pay + $overtimePay) . "<br/>";
	echo "Average Pay: " . ($pay + $overtimePay) / $hoursWorked . "<br/>";

	$cost = 200;
	$savings = 150;

	echo "<br/>";

	if ($cost > $savings) {
		echo "Need to save more!";
	} else {
		echo "Get spending!";
	}

	echo "<br/>";

	$myVar = true;
	switch ($myVar) {
		case true:
			echo "Value is true";
			break;
		case false:
			echo "Value is false";
			break;
	}
?>
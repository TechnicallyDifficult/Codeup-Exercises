<?php

// Set the default timezone
date_default_timezone_set('America/Chicago');

// Get Day of Week as number
// 1 (for Monday) through 7 (for Sunday)
$dayOfWeek = date('N');

switch($dayOfWeek) {
	 case 1:
		$day = 'Monday';
		break;
	 case 2:
		$day = 'Tuesday';
		break;
	 case 3:
	 	$day = 'Wednesday';
	 	break;
	 case 4:
	 	$day = 'Thursday';
	 	break;
	 case 5:
	 	$day = 'Friday';
	 	break;
	 case 6:
	 	$day = 'Saturday';
	 	break;
	 case 7:
	 	$day = 'Sunday';
	 	break;
}

fwrite(STDOUT, $day . PHP_EOL);

if ($dayOfWeek == 1) {
	$day2 = 'Monday';
} elseif ($dayOfWeek == 2) {
	$day2 = 'Tuesday';
} elseif ($dayOfWeek == 3) {
	$day2 = 'Wednesday';
} elseif ($dayOfWeek == 4) {
	$day2 = 'Thursday';
} elseif ($dayOfWeek == 5) {
	$day2 = 'Friday';
} elseif ($dayOfWeek == 6) {
	$day2 = 'Saturday';
} elseif ($dayOfWeek == 7) {
	$day2 = 'Sunday';
}

fwrite(STDOUT, $day2 . PHP_EOL);
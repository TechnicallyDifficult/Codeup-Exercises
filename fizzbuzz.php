<?php

for ($i = 1; $i <= 100; $i++) {
	$output = "$i";
	if ($i % 3 == 0) {
		$output .= 'Fizz';
		$output = preg_replace('~\d~', '', $output);
	}
	if ($i % 5 == 0) {
		$output .= 'Buzz';
		$output = preg_replace('~\d~', '', $output);
	}
	echo $output . PHP_EOL;
}
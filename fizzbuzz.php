<?php

for ($i = 1; $i <= 100; $i++) {
	$output = '';
	if ($i % 3 == 0) {
		$output .= 'Fizz';
	}
	if ($i % 5 == 0) {
		$output .= 'Buzz';
	}
	fwrite(STDOUT, ($output ? $output : $i) . PHP_EOL);
}
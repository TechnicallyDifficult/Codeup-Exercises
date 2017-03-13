<?php

$x = 0;
$y = 5;
$z = 10;

if ($x < $y and $y < $z) {
	echo "$x < $y < $z" . PHP_EOL;
}

if (0 < $x or $x < 10) {
	echo "0 is less than $x OR $x is less than 10" . PHP_EOL;
}

// TODO:
// repeat the if statement for $y and $z.

if (0 < $y or $y < 10) {
	echo "0 is less than $y OR $y is less than 10" . PHP_EOL;
}

if (0 < $z or $z < 10) {
	echo "0 is less than $z OR $z is less than 10" . PHP_EOL;
}

// TODO:
// If 0 is less than $x AND $x is less than 10
// then echo the result as a sentence "0 is less than {$x} AND {$x} is less than 10".

// TODO:
// repeat the if statement for $y and $z.

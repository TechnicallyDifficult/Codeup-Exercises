<?php

$a = 5;
$b = 10;
$c = '10';

if ($a < $b) {
    echo "$a is less than $b" . PHP_EOL;
}

if ($b > $a) {
    echo "$b is greater than $a" . PHP_EOL;
}

if ($b >= $c) {
    echo "$b is greater than or equal to $c" . PHP_EOL;
}

if ($b <= $c) {
    echo "$b is less than or equal to $c" . PHP_EOL;
}

if ($b == $c) {
    echo "$b is equal to $c" . PHP_EOL;
}

if ($b === $c) {
    echo "$b is identical to $c" . PHP_EOL;
}

// TODO: Replace `true` with the correct comparison
if ($b != $c) {
    echo "$b is not equal to $c" . PHP_EOL;
}

// TODO: Replace `true` with the correct comparison
if ($b !== $c) {
    echo "$b is not identical to $c" . PHP_EOL;
}

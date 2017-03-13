<?php

$a = 5;
$b = 10;
$c = '10';

if ($a < $b) {
    echo "$a is less than $b" . PHP_EOL;
} else {
    echo "$a is greater than or equal to $b" . PHP_EOL;
}

if ($b < $c) {
    echo "$b is less than $c" . PHP_EOL;
} else {
    echo "$b is greater than or equal to $c" . PHP_EOL;
}

if ($b === $c) {
    echo "$b is identical to $c" . PHP_EOL;
} elseif ($b == $c) {
    echo "$b is equal to $c" . PHP_EOL;
} else {
    echo "$b is not equal to $c" . PHP_EOL;
}
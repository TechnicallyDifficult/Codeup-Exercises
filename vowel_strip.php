<?php

$letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'];

function stripVowels($array) {
	$vowels = ['a', 'e', 'i', 'o', 'u'];
	foreach ($array as $index => $letter) {
		if (array_search($letter, $vowels) !== false) {
			unset($array[$index]);
		}
	}
	return $array;
}

$letters = stripVowels($letters);

print_r($letters);

?>
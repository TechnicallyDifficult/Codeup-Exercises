<?php

$testArray = ['e', 'a', 'g', 'c', 'i', 'd', 'f', 'b', 'h'];

function sortAlphabetical($array)
{
	$range = range('a', 'z');

	$newArray = [];

	$minimum = -1;

	for ($i = 0; $i < sizeof($array); $i++) {
		$currentSmallest = 26;
		foreach ($array as $letter) {
			$index = array_search($letter, $range);
			if ($index > $minimum and $index < $currentSmallest) {
				$currentSmallest = $index;
				$pushValue = $letter;
			}
		}
		$newArray[] = $pushValue;
		$minimum = $currentSmallest;
		echo $minimum;
	}
	return $newArray;
}

print_r(sortAlphabetical($testArray));
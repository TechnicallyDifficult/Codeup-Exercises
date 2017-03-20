<?php

$names = ['Tina', 'Dana', 'Mike', 'Amy', 'Adam'];

$compare = ['Tina', 'Dean', 'Mel', 'Amy', 'Michael'];

function hasValue($haystack, $needle)
{
	
	return array_search($needle, $haystack) !== false ? true : false;
}

function compareArrays($a, $b)
{
	$matching = 0;
	foreach ($a as $value) {
		if (array_search($value, $b) !== false) $matching++;
	}
	return $matching;
}
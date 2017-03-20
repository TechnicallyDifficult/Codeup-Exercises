<?php

$names = ['Tina', 'Dana', 'Mike', 'Amy', 'Adam'];

$compare = ['Tina', 'Dean', 'Mel', 'Amy', 'Michael'];

function hasValue($haystack, $needle)
{
	
	return array_search($needle, $haystack) !== false ? true : false;
}
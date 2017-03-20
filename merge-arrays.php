<?php

$names = ['Tina', 'Dana', 'Mike', 'Amy', 'Adam'];

$compare = ['Tina', 'Dean', 'Mel', 'Amy', 'Michael'];

$aNewOne = ['potato', 'Tina', 'terrible', 'persuasion error', '42', 'hahahahahahahaha', 'potato again'];

function combine_arrays()
{
	$newArray = [];
	$arrays = func_get_args();
	rsort($arrays);
	for ($i = 0; $i < sizeof($arrays[0]); $i++) {
		for ($j = 0; $j < sizeof($arrays); $j++) {
			if ($i >= sizeof($arrays[$j])) {
				break;
			}
			if (!in_array($arrays[$j][$i], $newArray)) {
				$newArray[] = $arrays[$j][$i];
			}
		}
	}
	return $newArray;
}

print_r(combine_arrays($names, $compare, $aNewOne));
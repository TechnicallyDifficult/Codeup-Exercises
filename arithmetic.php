<?php

function add($a, $b)
{
	return $a + $b;
}

function subtract($a, $b)
{
	return $a - $b;
}

function multiply($a, $b)
{
	$result = 0;
	$a *= $b / abs($b);
	$b = abs($b);

	for ($i = 0; $i < $b; $i++) { 
		$result += $a;
	}

	return $result;
}

function divide($a, $b)
{
	$result = '';
	$r = $a;
	$i = 0;
	while (multiply(((float) $result), $b) < $a) {
		$value = 0;
		while ($i <= $r) {
			if ($i + $b <= $r) {
				$value++;
			} else {
				$result .= "$value";
				if ($r != 0 and !strpos($result, '.')) {
					$result .= '.';
				}
				$r -= $i;
				$r *= 10;
				break;
			}
			$i += $b;
		}
		$i = 0;
	}
	return $result;
}
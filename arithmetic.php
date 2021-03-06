<?php

function add($a, $b)
{
	$valueCheck = throwErrorMessage($a, $b);
	if ($valueCheck) return $valueCheck;
	return $a + $b;
}

function subtract($a, $b)
{
	$valueCheck = throwErrorMessage($a, $b);
	if ($valueCheck) return $valueCheck;
	return $a - $b;
}

function multiply($a, $b)
{
	$valueCheck = throwErrorMessage($a, $b);
	if ($valueCheck) return $valueCheck;
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
	$valueCheck = throwErrorMessage($a, $b);
	if ($valueCheck) return $valueCheck;
	if ($b == 0) return 'undefined';
	$result = '';
	$r = $a;
	$i = 0;
	while (multiply((float) $result, $b) < $a) {
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

function modulus($a, $b)
{
	$valueCheck = throwErrorMessage($a, $b);
	if ($valueCheck) return $valueCheck;
	$a = (int) $a;
	$b = (int) $b;
	if ($b == 0) return 'undefined';
	if ($a < $b) return $a;
	for ($i = 0; multiply($i, $b) <= $a; $i++) {
		if (multiply($i + 1, $b) > $a) return $a - $i;
	}
}

function throwErrorMessage($A, $B)
{
	if (is_numeric($A) and is_numeric($B)) return false;
	$message = 'ERROR -- NON-NUMERIC VALUES: ';
	if (!is_numeric($A)) {
		$message .= is_string($A) ? "\"$A\"" : $A;
		if (!is_numeric($B)) $message .= ', ';
	}
	if (!is_numeric($B)) $message .= is_string($B) ? "\"$B\"" : $B;
	return $message;
}
<?php

function multiply($a, $b)
{
	$negative = rememberNegative($a, $b);

	$a = removeExtraZeroes($a);
	$b = removeExtraZeroes($b);

	$decimalPlaces = rememberDecimals($a) + rememberDecimals($b);

	$a = strrev($a);
	$b = strrev($b);

	$result = multiplyStrings($a, $b);

	$result = recallDecimals($result, $decimalPlaces);

	$result = strrev($result);

	$result = removeExtraZeroes($result);

	if ($negative and $result !== '0') $result = '-' . $result;

	return $result;
}

function rememberDecimals(&$str)
{
	$pos = strpos($str, '.');

	$decimals = ($pos !== false and $pos !== strlen($str) - 1) ? strlen(substr($str, $pos + 1)) : 0;

	$str = str_replace('.', '', $str);

	return $decimals;
}

function recallDecimals($str, $decimals)
{
	$newStr = substr($str, 0, $decimals) . '.' . substr($str, $decimals);
	return $newStr;
}

function rememberNegative(&$a, &$b)
{
	if ($a < 0 xor $b < 0) {
		if ($a < 0) {
			$a = substr($a, 1);
		} else {
			$b = substr($b, 1);
		}
		return true;
	} else {
		if ($a < 0 and $b < 0) {
			$a = substr($a, 1);
			$b = substr($b, 1);
		}
		return false;
	}
}

function removeExtraZeroes($str)
{
	return preg_replace(['#^0*(\d+)#', '#(?:\.(\d*[1-9]+)*0+)$#', '#\.$#'], ['$1', '.$1', ''], $str);
}

function increment($x)
{
	switch ($x[0]) {
		case '0':
			$x[0] = '1';
			break;
		case '1':
			$x[0] = '2';
			break;
		case '2':
			$x[0] = '3';
			break;
		case '3':
			$x[0] = '4';
			break;
		case '4':
			$x[0] = '5';
			break;
		case '5':
			$x[0] = '6';
			break;
		case '6':
			$x[0] = '7';
			break;
		case '7':
			$x[0] = '8';
			break;
		case '8':
			$x[0] = '9';
			break;
		case '9':
			$x[0] = '0';
			isset($x[1]) ?: $x .= '0';
			$x = $x[0] . increment(substr($x, 1));
			break;
	}
	return $x;
}

function addStrings($a, $b)
{
	padStrings($a, $b);
	$result = $a;
	for ($i = 0; $i < strlen($a); $i++) {
		$segment = substr($result, $i);
		for ($j = '0'; $j !== substr($b, $i, 1); $j = increment($j)) {
			$segment = increment($segment);
		}
		$result = substr($result, 0, $i) . $segment;
	}
	return $result;
}

function multiplyStrings($a, $b)
{
	$result = $a;
	if ($a === '0' or $b === '0') return '0';
	if ($a === '1') return $b;
	for ($i = '1'; $i !== $b; $i = increment($i)) {
		$result = addStrings($result, $a);
	}
	return $result;
}

function padStrings(&$a, &$b)
{
	while (strlen($a) < strlen($b)) {
		$a .= '0';
	}
	while (strlen($b) < strlen($a)) {
		$b .= '0';
	}
}
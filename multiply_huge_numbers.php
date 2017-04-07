<?php

function multiply($a, $b)
{
	if (!is_string($a) or !is_string($b) or !is_numeric($a) or !is_numeric($b)) {
		trigger_error('Both parameters must be numeric strings.', E_USER_WARNING);
	}
	$A = $a;
	$B = $b;

	$negCoefficient = rememberNegative($A, $B);

	$A = removeExtraZeroes($A);
	$B = removeExtraZeroes($B);

	$decimalPlaces = rememberDecimals($A) + rememberDecimals($B);

	$A = array_reverse(str_split($A));
	$B = array_reverse(str_split($B));

	$products = multiplyArrays($A, $B);

	padWithZeroes($products);

	$sum = addProducts($products);

	$result = implode('', array_reverse($sum));

	$result = recallDecimals($result, $decimalPlaces);

	$result = removeExtraZeroes($result);

	$negCoefficient ?: $result = '-' . $result;

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
	$newStr = strrev($str);
	$newStr = substr($newStr, 0, $decimals) . '.' . substr($newStr, $decimals);
	return strrev($newStr);
}

function rememberNegative(&$a, &$b)
{
	if ($a < 0 xor $b < 0) {
		if ($a < 0) {
			$a = substr($a, 1);
		} else {
			$b = substr($b, 1);
		}
		return false;
	} else {
		if ($a < 0 and $b < 0) {
			$a = substr($a, 1);
			$b = substr($b, 1);
		}
		return true;
	}
}

function removeExtraZeroes($str)
{
	return preg_replace(['#^0*(\d+)#', '#(?:\.(\d*[1-9]+)*0+)$#', '#\.$#'], ['$1', '.$1', ''], $str);
}

function multiplyArrays($A, $B)
{
	$products = [];
	foreach ($B as $indexOfB => $b) {
		$products[] = [];
		foreach ($A as $indexOfA => $a) {
			$digitProduct = (int) $b * (int) $a;
			isset($products[$indexOfB][$indexOfA]) ? $products[$indexOfB][$indexOfA] += $digitProduct : $products[$indexOfB][$indexOfA] = $digitProduct;
			carryTheOne($products[$indexOfB], $indexOfA);
		}
		carryTheOne($products[$indexOfB], sizeof($products[$indexOfB]) - 1);
	}
	return $products;
}

function carryTheOne(&$array, $index)
{
	if (strlen((string) $array[$index]) > 1) {
		if ($index < sizeof($array) - 1) {
			$array[$index + 1] += (int) substr((string) $array[$index], 0, 1);
		} else {
			$array[] = (int) substr((string) $array[$index], 0, 1);
		}
		$array[$index] = (int) substr($array[$index], 1);
	}
}

function padWithZeroes(&$addends)
{
	foreach ($addends as $index => &$addend) {
		for ($i = 0; $i < $index; $i++) {
			array_unshift($addend, 0);
		}
		for ($i = $index; $i < sizeof($addends) - 1; $i++) {
			$addend[] = 0;
		}
	}
}

function addProducts($addends)
{
	$result = array_fill(0, sizeof($addends[0]), 0);
	foreach ($addends as $addend) {
		foreach ($addend as $index => $digit) {
			isset($result[$index]) ? $result[$index] += $digit : $result[$index] = $digit;
			carryTheOne($result, $index);
		}
		carryTheOne($result, sizeof($result) - 1);
	}
	return $result;
}
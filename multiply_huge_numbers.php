<?php

function multiply($a, $b)
{
	if (!is_string($a) or !is_string($b) or !is_numeric($a) or !is_numeric($b)) {
		trigger_error('Both parameters must be numeric strings.', E_USER_WARNING);
	}

	$negCoefficient = rememberNegative($a, $b);

	$a = removeExtraZeroes($a);
	$b = removeExtraZeroes($b);

	$decimalPlaces = rememberDecimals($a) + rememberDecimals($b);

	$a = strrev($a);
	$b = strrev($b);

	$products = multiplyStrings($a, $b);

	padWithZeroes($products);

	$sum = addProducts($products);

	$sum = recallDecimals($sum, $decimalPlaces);

	$result = strrev($sum);

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

function multiplyStrings($a, $b)
{
	$products = [];
	for ($i = 0; $i < strlen($b); $i++) {
		$products[$i] = '';
		$carry = '0';
		for ($j = 0; $j < strlen($a); $j++) {
			$digit = strrev((string) (((int) $b[$i] * (int) $a[$j]) + (int) strrev($carry)));
			$products[$i] .= $digit[0];
			$carry = strlen($digit) > 1 ? substr($digit, 1) : '0';
		}
		$products[$i] .= $carry;
	}
	return $products;
}

function padWithZeroes(&$addends)
{
	foreach ($addends as $index => &$addend) {
		for ($i = 0; $i < $index; $i++) {
			$addend = '0' . $addend;
		}
		for ($i = $index; $i < sizeof($addends) - 1; $i++) {
			$addend .= '0';
		}
	}
}

function addProducts($addends)
{
	$result = '';
	$carry = '';
	for ($i = 0; $i < strlen($addends[0]); $i++) {
		$digit = 0;
		foreach ($addends as $addend) {
			$digit += (int) $addend[$i];
		}
		$digit = strrev((string) ($digit + (int) strrev($carry)));
		$result .= $digit[0];
		$carry = strlen($digit) > 1 ? substr($digit, 1) : '';
	}
	$result .= $carry;

	return $result;
}
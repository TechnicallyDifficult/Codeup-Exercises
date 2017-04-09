<?php

function multiply($a, $b)
{
	$negative = rememberNegative($a, $b);

	$a = removeExtraZeroes($a);
	$b = removeExtraZeroes($b);

	$decimalPlaces = rememberDecimals($a) + rememberDecimals($b);

	$a = decimalToUnary(strrev($a));
	$b = decimalToUnary(strrev($b));

	$uResult = multiplyUnary($a . $b);

	$result = unaryToDecimal($uResult);

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

function decimalToUnary($str)
{
	$uStr = preg_replace(['#0#', '#1#', '#2#', '#3#', '#4#', '#5#', '#6#', '#7#', '#8#', '#9#', ], [',.', ',1.', ',11.', ',111.', ',1111.', ',11111.', ',111111.', ',1111111.', ',11111111.', ',111111111.'], $str);
	$uStr = '?' . $uStr . '!';
	return $uStr;
}

function unaryToDecimal($str)
{
	$dStr = preg_replace(['#,1{9}\.#', '#,1{8}\.#', '#,1{7}\.#', '#,1{6}\.#', '#,1{5}\.#', '#,1{4}\.#', '#,1{3}\.#', '#,1{2}\.#', '#,1\.#', '#,\.#', '#[!\?]#'], ['9', '8', '7', '6', '5', '4', '3', '2', '1', '0', ''], $str);
	return $dStr;
}

function increment(&$x)
{
	switch ($x) {
		case '0':
			$x = '1';
			break;
		case '1':
			$x = '2';
			break;
		case '2':
			$x = '3';
			break;
		case '3':
			$x = '4';
			break;
		case '4':
			$x = '5';
			break;
		case '5':
			$x = '6';
			break;
		case '6':
			$x = '7';
			break;
		case '7':
			$x = '8';
			break;
		case '8':
			$x = '9';
			break;
		case '9':
			$x = '0';
			return true;
	}
	return false;
}

function strposX($haystack, $needle, $number)
{
	$skipped = '';
	$pos = strpos($haystack, $needle);
	$newHaystack = $haystack;
	for ($i = 1; $i < $number; $i++) {
		$newHaystack = substr($newHaystack, strpos($newHaystack, $needle));
		$skipped .= substr($haystack, 0, strlen($haystack) - strlen($newHaystack));
		// $pos += 1;
		// $pos += strpos($haystack, $needle, $pos) - 1;
		$haystack = $newHaystack;
		// echo $pos . PHP_EOL;
	}
	return strpos($haystack, $needle, strlen($skipped));
	// if ($number == '1') {
	// 	return strpos($haystack, $needle);
	// } elseif ($number > '1') {
	// 	return strpos($haystack, $needle, strposX($haystack, $needle, $number - 1) + strlen($needle));
	// } else {
	// 	return error_log('Error: Value for parameter $number is out of range');
	// }
}

function substrXY($str, $start, $end)
{
	$length = strlen(substr($str, $end));
	return substr($str, $start, -$length);
}

function multiplyUnary($str)
{
	$a = substrXY($str, 0, strpos($str, '!') + 1);
	$b = substr($str, strposX($str, '?', 2));
	$addStr = '';

	if ($a === '?,.!' or $b === '?,.!') return '?,.!';
	if ($a === '?,1.!') return $b;
	if ($b === '?,1.!') return $a;

	for ($i = '?,.!'; $i !== $b; $i = uPlusPlus($i)) {
		$addStr .= $a;
	}
	return addUnary($addStr);
}

function uPlusPlus($str)
{
	$one = '?,1.!';

	while (getDigitCount($one, 1) < getDigitCount($str, 1)) {
		$one = substr($one, 0, -1) . ',.!';
	}
	echo $str . $one . PHP_EOL;
	return addUnary($str . $one);
}

function addUnary($str)
{
	$result = '?';
	$numbers = getNumberCount($str);
	$maxDigits = getMaxDigits($str);
	$digit = '';
	$carry = '';
	for ($i = 1; $i <= $maxDigits; $i++) {
		for ($j = 1; $j <= $numbers; $j++) {
			$currentNumber = substrXY($str, strposX($str, '?', $j) + 1, strposX($str, '!', $j));
			$digit .= substrXY($currentNumber, strposX($currentNumber, ',', $i) + 1, strposX($currentNumber, '.', $i));
		}
		$digit .= $carry;
		$carry = '';
		while (strlen($digit) > 9) {
			$carry .= '1';
			$digit = substr($digit, 10);
		}
		$result .= ',' . $digit . '.';
		$digit = '';
	}
	if ($carry) $carry = ',' . $carry . '.';
	$result .= $carry . '!';
	return $result;
}

function addStrings($str)
{}

function getNumberCount($str)
{
	return preg_match_all('#\?#', $str);
}

function getDigitCount($str, $num)
{
	return preg_match_all('#,#', substrXY($str, strposX($str, '?', $num), strposX($str, '!', $num)));
}

function getMaxDigits($str)
{
	$numbers = getNumberCount($str);
	$max = 0;

	for ($i = 1; $i <= $numbers; $i++) {
		$digits = getDigitCount($str, $i);
		if ($digits > $max) $max = $digits;
	}
	return $max;
}
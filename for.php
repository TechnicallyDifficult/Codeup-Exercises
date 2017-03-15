<?php


fwrite(STDOUT, PHP_EOL . 'INPUT START NUMBER' . PHP_EOL);
$start = trim(fgets(STDIN));

while (!is_numeric($start)) {
	fwrite(STDOUT, PHP_EOL . 'ERROR -- NEED NUMBER' . PHP_EOL);
	$start = trim(fgets(STDIN));
}

if ((int) $start != (double) $start) {
	fwrite(STDOUT, PHP_EOL . 'FLOAT ACCEPTED -- ROUNDING DOWN');
}

$start = (int) $start;



fwrite(STDOUT, PHP_EOL . 'INPUT END NUMBER' . PHP_EOL);
$end = trim(fgets(STDIN));

while (!is_numeric($end)) {
	fwrite(STDOUT, PHP_EOL . 'ERROR -- NEED NUMBER' . PHP_EOL);
	$end = trim(fgets(STDIN));
}

if ((int) $end != (double) $end) {
	fwrite(STDOUT, PHP_EOL . 'FLOAT ACCEPTED -- ROUNDING DOWN');
}

$end = (int) $end;



fwrite(STDOUT, PHP_EOL . 'INPUT INCREMENT OR LEAVE BLANK FOR DEFAULT' . PHP_EOL);
$increment = trim(fgets(STDIN));

if ((int) $increment != (double) $increment) {
	fwrite(STDOUT, PHP_EOL . 'FLOAT ACCEPTED -- ROUNDING DOWN');
	$increment = (int) $increment;
}

$ok = false;

while(!$ok) {
	while ($increment != '' and (!is_numeric($increment) or ($increment < 0 and $start < $end) or ($increment > 0 and $start > $end) or $increment == 0)) {
		if (!is_numeric($increment)) {
			$error = 'NEED NUMBER';
		} elseif ($increment < 0) {
			$error = 'MUST BE GREATER THAN ZERO';
		} elseif ($increment > 0) {
			$error = 'MUST BE LESS THAN ZERO';
		} elseif ($increment == 0) {
			$error = 'MUST NOT BE ZERO';
		}
		fwrite(STDOUT, PHP_EOL . 'ERROR -- ' . $error . PHP_EOL);
		$increment = trim(fgets(STDIN));
		if ((int) $increment != (double) $increment) {
			fwrite(STDOUT, 'FLOAT ACCEPTED -- ROUNDING DOWN');
			$increment = (int) $increment;
		}
	}

	if ($increment === '') {
		$increment = 1;
	}

	$increment = (int) $increment;

	// if (($end - $start) % $increment != 0) {
	// 	fwrite(STDOUT, PHP_EOL . 'MAY NOT REACH END - OK?' . PHP_EOL);
	// 	$consent = '';
	// 	while ($consent !== 'Y' and $consent !== 'YES' and $consent !== 'N' and $consent !== 'NO') {
	// 		fwrite(STDOUT, '(Y/N)' . PHP_EOL);
	// 		$consent = strtoupper(trim(fgets(STDIN)));
	// 		if ($consent === 'Y' or $consent === 'YES') {
	// 			$ok = true;
	// 		} else {
	// 			fwrite(STDOUT, PHP_EOL . 'INPUT INCREMENT OR LEAVE BLANK FOR DEFAULT' . PHP_EOL);
	// 			$increment = trim(fgets(STDIN));
	// 		}
	// 	}
	// } else {
	// 	$ok = true;
	// }
}

echo $increment;

// for ($i = $start, fwrite(STDOUT, PHP_EOL . 'BEGINNING PROCESS' . PHP_EOL); $i <= $end; $i += $increment) {
// 	fwrite(STDOUT, $i . PHP_EOL);
// }
// fwrite(STDOUT, 'ALL DONE' . PHP_EOL);



exit(0);
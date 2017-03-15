<?php

fwrite(STDOUT, PHP_EOL . 'INPUT START NUMBER' . PHP_EOL);
$start = trim(fgets(STDIN));

while (!is_numeric($start)) {
	fwrite(STDOUT, PHP_EOL . 'ERROR -- NEED NUMBER' . PHP_EOL);
	$start = fgets(STDIN);
}

if ((int) $start != (double) $start) {
	fwrite(STDOUT, PHP_EOL . 'FLOAT ACCEPTED -- ROUNDING DOWN');
}

$start = (int) $start;

fwrite(STDOUT, PHP_EOL . 'INPUT END NUMBER' . PHP_EOL);
$end = trim(fgets(STDIN));

while (!is_numeric($end) or (int) $end <= $start) {
	if ((int) $end != (double) $end) {
		fwrite(STDOUT, PHP_EOL . 'FLOAT ACCEPTED -- ROUNDING DOWN');
	}
	fwrite(STDOUT, PHP_EOL . 'ERROR -- ' . (!is_numeric($end) ? 'NEED NUMBER' : 'MUST BE GREATER THAN START') . PHP_EOL);
	$end = fgets(STDIN);
}

if ((int) $end != (double) $end) {
	fwrite(STDOUT, PHP_EOL . 'FLOAT ACCEPTED -- ROUNDING DOWN' . PHP_EOL);
}

$end = (int) $end;

for ($i = $start, fwrite(STDOUT, PHP_EOL . 'BEGINNING PROCESS' . PHP_EOL); $i <= $end; $i++) {
	fwrite(STDOUT, $i . PHP_EOL);
}
fwrite(STDOUT, 'ALL DONE' . PHP_EOL);

exit(0);
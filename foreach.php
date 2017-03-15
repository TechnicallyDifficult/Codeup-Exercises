<?php

$things = array('Sgt. Pepper', "11", null, array(1,2,3), 3.14, "12 + 7", false, (string) 11);

fwrite(STDOUT, PHP_EOL);

foreach ($things as $thing) {
	fwrite(STDOUT, strtolower(gettype($thing)) . PHP_EOL);
}

fwrite(STDOUT, PHP_EOL . '---------------------------------' . PHP_EOL . PHP_EOL);

foreach ($things as $thing) {
	if (is_scalar($thing)) {
		fwrite(STDOUT, $thing . PHP_EOL);
	}
}

fwrite(STDOUT, PHP_EOL . '---------------------------------' . PHP_EOL . PHP_EOL);

foreach ($things as $thing) {
	if (is_array($thing)) {
		$arrayContents = '';
		foreach ($thing as $thingItem) {
			$arrayContents .= $thingItem . ', ';
		}
		echo 'Array [' . substr($arrayContents, 0, -2) . ']' . PHP_EOL;
	} else {
		echo $thing . PHP_EOL;
	}
}
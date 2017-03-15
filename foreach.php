<?php

$things = array('Sgt. Pepper', "11", null, array(1,2,3), 3.14, "12 + 7", false, (string) 11);

foreach ($things as $thing) {
	fwrite(STDOUT, strtolower(gettype($thing)) . PHP_EOL);
}

fwrite(STDOUT, PHP_EOL);

foreach ($things as $thing) {
	if (is_scalar($thing)) {
		fwrite(STDOUT, $thing);
	}
}
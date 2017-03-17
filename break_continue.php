<?php

foreach (range(1, 100) as $i) {
	if ($i % 2 === 1) {
		continue;
	}
	fwrite(STDOUT, $i . PHP_EOL);
}

fwrite(STDOUT, PHP_EOL);

foreach (range(1, 100) as $i) {
	if ($i > 10) {
		break;
	}
	fwrite(STDOUT, $i . PHP_EOL);
}
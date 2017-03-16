<?php

$states = [
	'AL' => 'Alabama',
	'AK' => 'Alaska',
	'AZ' => 'Arizona',
	'AR' => 'Arkansas',
	'CA' => 'California',
	'CO' => 'Colorado',
	'CT' => 'Connecticut',
	'DE' => 'Delaware',
	'DC' => 'District of Columbia',
	'FL' => 'Florida',
	'GA' => 'Georgia',
	'HI' => 'Hawaii',
	'ID' => 'Idaho',
	'IL' => 'Illinois',
	'IN' => 'Indiana',
	'IA' => 'Iowa',
	'KS' => 'Kansas',
	'KY' => 'Kentucky',
	'LA' => 'Louisiana',
	'ME' => 'Maine',
	'MD' => 'Maryland',
	'MA' => 'Massachusetts',
	'MI' => 'Michigan',
	'MN' => 'Minnesota',
	'MS' => 'Mississippi',
	'MO' => 'Missouri',
	'MT' => 'Montana',
	'NE' => 'Nebraska',
	'NV' => 'Nevada',
	'NH' => 'New Hampshire',
	'NJ' => 'New Jersey',
	'NM' => 'New Mexico',
	'NY' => 'New York',
	'NC' => 'North Carolina',
	'ND' => 'North Dakota',
	'OH' => 'Ohio',
	'OK' => 'Oklahoma',
	'OR' => 'Oregon',
	'PA' => 'Pennsylvania',
	'PR' => 'Puerto Rico',
	'RI' => 'Rhode Island',
	'SC' => 'South Carolina',
	'SD' => 'South Dakota',
	'TN' => 'Tennessee',
	'TX' => 'Texas',
	'VI' => 'US Virgin Islands',
	'UT' => 'Utah',
	'VT' => 'Vermont',
	'VA' => 'Virginia',
	'WA' => 'Washington',
	'WV' => 'West Virginia',
	'WI' => 'Wisconsin',
	'WY' => 'Wyoming'
];

foreach ($states as $state) {
	if (strpos($state, 'x')) {
		fwrite(STDOUT, $state . PHP_EOL);
	}
}

fwrite(STDOUT, PHP_EOL);

foreach ($states as $state) {
	if (!strpos($state, 'a')) {
		fwrite(STDOUT, $state . PHP_EOL);
	}
}

fwrite(STDOUT, PHP_EOL);

$vowels = ['A', 'E', 'I', 'O', 'U'];

foreach ($states as $abbr => $state) {
	if (in_array(substr($state, 0, 1), $vowels)) {
		fwrite(STDOUT, "$abbr, $state" . PHP_EOL);
	}
}

fwrite(STDOUT, PHP_EOL);

$statesStartingAndEndingWithVowels = [];

foreach ($states as $state) {
	if (in_array(substr($state, 0, 1), $vowels) and in_array(strtoupper(substr($state, -1)), $vowels)) {
		array_push($statesStartingAndEndingWithVowels, $state);
	}
}

fwrite(STDOUT, 'These are the states starting and ending with vowels:' . PHP_EOL);
foreach ($statesStartingAndEndingWithVowels as $state) {
	fwrite(STDOUT, $state . PHP_EOL);
}

fwrite(STDOUT, PHP_EOL);

$statesWithMoreThanOneWordNames = [];

foreach ($states as $state) {
	if (strpos($state, ' ')) {
		array_push($statesWithMoreThanOneWordNames, $state);
	}
}

fwrite(STDOUT, 'These are the states with more than one word in their name:' . PHP_EOL);

foreach ($statesWithMoreThanOneWordNames as $state) {
	fwrite(STDOUT, $state . PHP_EOL);
}

fwrite(STDOUT, PHP_EOL);

$arrayOfCardinalStates = [];
$cardinalDirections = ['North', 'South', 'East', 'West'];

foreach ($states as $state) {
	foreach ($cardinalDirections as $direction) {
		if (strpos($state, $direction) !== false) {
			array_push($arrayOfCardinalStates, $state);
		}
	}
}

fwrite(STDOUT, 'These are states with north, south, east, or west in their name:' . PHP_EOL);

foreach ($arrayOfCardinalStates as $state) {
	fwrite(STDOUT, $state . PHP_EOL);
}
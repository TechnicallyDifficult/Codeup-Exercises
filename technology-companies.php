<?php

$companies = [
    'Sun Microsystems' => [
        'Vinod Khosla',
        'Bill Joy',
        'Andy Bechtolsheim',
        'Scott McNealy'
    ],
    'Silicon Graphics' => [
        'Jim Clark',
        'Ed McCracken'
    ],
    'Cray' => [
        'William Norris',
        'Seymour Cray'
    ],
    'NeXT' => [
        'Steve Jobs',
        'Avie Tevanian',
        'Joanna Hoffman',
        'Bud Tribble',
        'Susan Kare'
    ],
    'Acorn Computers' => [
        'Steve Furber',
        'Sophie Wilson',
        'Hermann Hauser',
        'Jim Mitchell'
    ],
    'MIPS Technologies' => [
        'Skip Stritter',
        'John L. Hennessy'
    ],
    'Commodore' => [
        'Yash Terakura',
        'Bob Russell',
        'Bob Yannes',
        'David A. Ziembicki',
        'Jay Miner'
    ],
    'Be Inc' => [
        'Steve Sakoman',
        'Jean-Louis Gassée'
    ]
];

var_dump($companies);

echo PHP_EOL . '----------------------------------------------' . PHP_EOL . PHP_EOL;

ksort($companies);

var_dump($companies);

echo PHP_EOL . '----------------------------------------------' . PHP_EOL . PHP_EOL;

foreach ($companies as $company => $names) {
    $newOrder = [];
    sort($names);
    foreach ($names as $name) {
        $newOrder[] = $name;
    }
    $companies[$company] = $newOrder;
}

var_dump($companies);

echo PHP_EOL . '----------------------------------------------' . PHP_EOL . PHP_EOL;

arsort($companies);

var_dump($companies);
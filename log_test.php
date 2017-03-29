<?php

require_once './class/Log.php';

$log = new Log();
$log->filename = 'log-' . date('Y-m-d') . '.log';

$log->logMessage('FISH', 'potato');
$log->info();
$log->error();
<?php

require_once './class/Log.php';

$log = new Log('cli');

$log->logMessage();
$log->info();
$log->error();
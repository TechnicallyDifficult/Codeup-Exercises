<?php

function logMessage($logLevel, $file, $message)
{
	$filename = $file === false ? 'log-' . date('Y-m-d') . '.log' : $file;
	$handle = fopen($filename, 'a');
	fwrite($handle, PHP_EOL . date('Y-m-d G:i:s') . " [$logLevel] $message");
	fclose($handle);
}

function clearLog($file) {
	$filename = $file === false ? 'log-' . date('Y-m-d') . '.log' : $file;
	$handle = fopen($filename, 'w');
	fclose($handle);
}

function logInfo($file, $message)
{
	logMessage('INFO', $file, $message);
}

function logError($file, $message)
{
	logMessage('ERROR', $file, $message);
}

function start($function = 'log_info', $file = false, $message = false)
{
	switch ($function) {
		case 'log_info':
			logInfo($file, $message !== false ? $message : 'This is an info message.');
			break;
		case 'log_error':
			logError($file, $message !== false ? $message : 'This is an error message.');
			break;
		case 'clear':
			clearLog($file);
			break;
	}
}

$a = $argc > 1 ? $argv[1] : 'log_info';
$b = $argc > 2 ? $argv[2] : false;
$c = $argc > 3 ? $argv[3] : false;

start($a, $b, $c);
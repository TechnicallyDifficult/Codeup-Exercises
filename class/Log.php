<?php

class Log
{
	public $filename = './logs/log.txt';

	public function logMessage($logLevel, $message)
	{
		$handle = fopen($this->filename, 'a');
		fwrite($handle, PHP_EOL . date('Y-m-d G:i:s') . " [$logLevel] $message");
		fclose($handle);
	}

	public function info($message = 'This is an info message.')
	{
		$this->logMessage('INFO', $message);
	}

	public function error($message = 'This is an error message.')
	{
		$this->logMessage('ERROR', $message);
	}
}
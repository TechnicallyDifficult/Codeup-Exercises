<?php

class Log {

	public $filename;
	public $handle = NULL;

	public function __construct($prefix = 'log')
	{
		$this->changePrefix($prefix);
	}

	public function __destruct()
	{
		fclose($this->handle);
	}

	public function changePrefix($prefix = 'log')
	{
		$basename = "$prefix-" . date('Y-m-d');
		$this->setFilename($basename);
	}

	public function setFilename($basename = '')
	{
		$basename = preg_replace(['#[\/\\?%*:|"<>\s]#', '#\.\.+#', '#^\.#'], ['', '.', ''], $basename);
		if ($basename === '') {
			$this->changePrefix();
		} else {
			$this->filename = $basename . '.log';
			$this->openFile('a');
			$this->echoCurrentFile();
		}
	}

	public function openFile($mode)
	{
		is_null($this->handle) ?: fclose($this->handle);
		$this->handle = fopen($this->filename, $mode);
	}

	public function echoCurrentFile()
	{
		echo PHP_EOL . "current file: \"$this->filename\"" . PHP_EOL . PHP_EOL;
	}

	public function logMessage($logLevel = 'LOG', $message = 'log')
	{
		echo PHP_EOL . "writing to file: \"$this->filename\"" . PHP_EOL;
		$success = fwrite($this->handle, PHP_EOL . date('Y-m-d G:i:s') . " [$logLevel] $message");
		echo ($success ? 'log successfully written!' : 'something went wrong!') . PHP_EOL . PHP_EOL;
	}

	public function info($message = 'This is an info message.')
	{
		echo PHP_EOL . 'logging info message';
		$this->logMessage('INFO', $message);
	}

	public function error($message = 'This is an error message.')
	{
		echo PHP_EOL . 'logging error message';
		$this->logMessage('ERROR', $message);
	}

	public function clear()
	{
		echo PHP_EOL . "clearing file: \"$filename\"" . PHP_EOL;
		$this->openFile('w');
		echo 'log file cleared!' . PHP_EOL . PHP_EOL;
		$this->openFile('a');
	}

	public function view()
	{
		clearstatcache();
		echo PHP_EOL . "getting logs from: \"$this->filename\"" . PHP_EOL . PHP_EOL;
		$this->openFile('r');
		$fileContents = filesize($this->filename) === 0 ? '' : trim(fread($this->handle, filesize($this->filename)));
		echo '----------------------------------------------------------------' . PHP_EOL . $fileContents . PHP_EOL . '----------------------------------------------------------------' . PHP_EOL . PHP_EOL;
		$this->openFile('a');
	}
}
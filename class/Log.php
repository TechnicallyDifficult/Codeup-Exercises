<?php

class Log {

	private $filename;
	private $handle;
	private $deletable = false;

	public function __construct($prefix = 'log')
	{
		$this->changePrefix($prefix);
	}

	public function __destruct()
	{
		$this->closeFile();
	}

	public function changePrefix($prefix = 'log')
	{
		if (gettype($prefix) !== 'string') $prefix = 'log';
		$basename = "$prefix-" . date('Y-m-d');
		$this->setFilename($basename);
	}

	public function setFilename($basename = '')
	{
		if (isset($this->handle)) $this->closeFile();

		if (gettype($basename) !== 'string') $basename = '';

		$basename = preg_replace(['#[\/\\?%*:|"<>\s]#', '#\.\.+#', '#^\.#'], ['', '.', ''], $basename);

		if ($basename === '') {
			$this->changePrefix();
		} else {
			$this->filename = $basename . '.log';
			$this->deleteable = !file_exists($this->filename);
			$this->openFile('a');
		}
	}

	private function openFile($mode)
	{
		if (isset($this->handle)) $this->closeFile();

		is_writable($this->filename)
			or die;

		touch($this->filename)
			or die;

		$this->handle = fopen($this->filename, $mode);
	}

	private function closeFile()
	{
		fclose($this->handle);

		if ($this->deletable) unlink($this->filename);
	}

	public function getFilename()
	{
		return $this->filename;
	}

	public function log($logLevel = 'LOG', $message = 'log')
	{
		$this->deletable = false;

		return fwrite($this->handle, PHP_EOL . date('Y-m-d G:i:s') . " [$logLevel] $message");
	}

	public function info($message = 'info')
	{
		if (gettype($message) !== 'string') $message = 'info';

		$this->log('INFO', $message);
	}

	public function error($message = 'error')
	{
		if (gettype($message) !== 'string') $message = 'error';

		$this->log('ERROR', $message);
	}

	public function clear()
	{
		$this->openFile('w');
		$this->openFile('a');
	}
}
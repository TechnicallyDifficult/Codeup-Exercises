<?php

class Rectangle {
	private $length;
	private $width;

	public function __construct($length, $width)
	{
		$this->setLength($length);
		$this->setWidth($width);
	}

	private function setLength($x)
	{
		if (gettype($x) === 'integer') $this->length = $x;
	}

	private function setWidth($x)
	{
		if (gettype($x) === 'integer') $this->width = $x;
	}

	public function getLength()
	{
		return $this->length;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function area()
	{
		return $this->length * $this->width;
	}

	public function perimeter()
	{
		return ($this->length * 2) + ($this->width * 2);
	}
}
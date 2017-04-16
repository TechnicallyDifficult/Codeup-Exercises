<?php

class Rectangle {
	public $length;
	public $width;

	public function __construct($length, $width)
	{
		$this->length = (int) $length;
		$this->width = (int) $width;
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
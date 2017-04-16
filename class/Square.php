<?php

require_once './Rectangle.php';

class Square extends Rectangle {

	public function __construct($side)
	{
		$this->length = $side;
		$this->width =& $length;
	}

	public function area()
	{
		return pow($this->length, 2);
	}

	public function perimeter()
	{
		return $this->length * 4;
	}
}
<?php

class Rectangle {
	public $length;
	public $width;
	public $area;

	public function __construct($length, $width)
	{
		$this->length = (int) $length;
		$this->width = (int) $width;
		$this->area = $this->calculateArea();
	}

	public function calculateArea()
	{
		$area = $this->length * $this->width;
		echo "area is $area" . PHP_EOL;
		return $area;
	}

	public function changeDimensions($l = 1, $w = 1)
	{
		$this->length = (int) $l;
		echo "new length is $this->length" . PHP_EOL;
		$this->width = (int) $w;
		echo "new width is $this->width" . PHP_EOL;
		echo 'new ';
		$this->area = $this->calculateArea();
	}
}
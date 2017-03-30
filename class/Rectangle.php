<?php

class Rectangle {
	public $length;
	public $width;
	public $area;

	public function calculateArea()
	{
		$this->area = $this->length * $this->width;
		echo "area is $this->area" . PHP_EOL;
	}

	public function changeDimensions($l = 1, $w = 1)
	{
		$this->length = (int) $l;
		echo "new length is $this->length" . PHP_EOL;
		$this->width = (int) $w;
		echo "new width is $this->width" . PHP_EOL;
		echo 'new ';
		$this->calculateArea();
	}
}
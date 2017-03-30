<?php

class Pet {

	public $name;
	public $species;
	public $color;
	public $weight;

	public function eat()
	{
		echo "$this->name ate some food." . PHP_EOL;
	}

	public function move()
	{
		echo "$this->name moved somewhere else." . PHP_EOL;
	}

	public function sleep()
	{
		echo "$this->name took a nap." . PHP_EOL;
	}
}
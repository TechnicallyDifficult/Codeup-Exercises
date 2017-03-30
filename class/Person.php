<?php 

class Person {

	public $name;
	public $age;
	public $employed = false;
	public $dead = false;

	public function returnName()
	{
		return $this->name;
	}

	public function getOlder()
	{
		if ($this->dead) {
			echo "$this->name is dead." . PHP_EOL;
		} else {
			$this->age++;
			echo "$this->name grew to age $this->age." . PHP_EOL;
		}
	}

	public function echoAge()
	{
		echo ($this->dead ? "$this->name passed away at age " : "$this->name is currently age ") . "$this->age." . PHP_EOL;
	}

	public function quitJob() 
	{
		if (!$this->employed) {
			echo "$this->name has no job." . PHP_EOL;
		} else {
			$this->employed = false;
			echo "$this->name has quit their job." . PHP_EOL;
		}
	}

	public function getJob() 
	{
		if ($this->employed) {
			echo "$this->name already has a job." . PHP_EOL;
		} else {
			$this->employed = true;
			echo "$this->name now has a job." . PHP_EOL;
		}
	}

	public function passAway() 
	{
		if ($this->dead) {
			echo "$this->name is already dead." . PHP_EOL;
		} else {
			$this->dead = true;
			echo "$this->name passed away." . PHP_EOL;
		}
	}
}
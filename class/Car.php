<?php

class Car {
	public $make;
	public $model;
	public $color;
	public $miles = 0;
	public $on = false;
	public $speed = 0;

	public function turnOn()
	{
		if ($this->on) {
			echo 'The car is already on.' . PHP_EOL;
		} else {
			$this->on = true;
			echo 'The car is now on.' . PHP_EOL;
		}
	}

	public function turnOff()
	{
		if (!$this->on) {
			echo 'The car is not on.' . PHP_EOL;
		} else {
			$this->on = false;
			echo 'The car is now off.';
			if ($this->speed !== 0) {
				echo ' It continues to roll onward due to its momentum.';
			}
			echo PHP_EOL;
		}
	}

	public function brake()
	{
		if ($this->speed === 0) {
			echo 'The motionless car jerks, but nothing else happens.' . PHP_EOL;
		} else {
			$this->speed = 0;
			echo 'The car comes to a stop.' . PHP_EOL;
		}
	}

	public function honk()
	{
		echo 'The car emits a loud "Honk!" noise, aggrivating everyone in proximity.' . PHP_EOL;
	}

	public function accelerate($to = NULL)
	{
		if (!$this->on) {
			echo 'The idle engine does not respond.' . PHP_EOL;
		} else {
			$change = 'accelerates to';
			if (is_numeric($to)) {
				$to = (int) $to;
				if ($to < $this->speed) {
					$change = 'decelerates to';
				} elseif ($to === $this->speed) {
					$change = 'is already moving at';
				}
				$this->speed = $to;
			} else {
				$this->speed++;
			}
			echo "The car $change $this->speed mph." . PHP_EOL;
		}
	}

	public function driveToDestination()
	{
		echo 'The trip begins.' . PHP_EOL;
		$this->turnOn();
		$this->accelerate(5);
		echo 'The car pulls out of the driveway.' . PHP_EOL;
		$this->accelerate(20);
		for ($i=0; $i < mt_rand(2, 5); $i++) { 
			echo 'The car drives for a while.' . PHP_EOL;
			if (!mt_rand(0, 3)) {
				echo 'Another car suddenly cuts in front!' . PHP_EOL;
				$this->brake();
				$this->honk();
				$this->accelerate(5);
				echo 'The car swerves around the irresponsible driver.' . PHP_EOL;
				$this->accelerate(20);
			}
		}
		echo 'The car nears its destination' . PHP_EOL;
		$this->accelerate(5);
		echo 'The car pulls into the driveway.' . PHP_EOL;
		$this->brake();
		$this->turnOff();
		echo 'The destination has been reached.' . PHP_EOL;
	}
}
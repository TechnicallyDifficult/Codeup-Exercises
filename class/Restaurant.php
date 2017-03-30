<?php

class Restaurant {
	
	public $name;
	public $hours = ['open' => NULL, 'close' => NULL];
	public $menu = [];
	public $rating;
	public $orderProcess = ['orderItem' => NULL, 'orderMade' => false, 'tableDirty' => false];

	public function __construct($name, $open, $close, array $menu, $rating)
	{
		$this->name = $name;
		$this->hours['open'] = $open;
		$this->hours['close'] = $close;
		$this->menu = array_values($menu);
		$this->rating = $rating;

	}

	public function takeOrder($order = NULL)
	{
		if ($this->orderProcess['tableDirty']) {
			echo 'table\'s dirty... need to clean first...' . PHP_EOL;
		} elseif (!is_null($this->orderProcess['orderItem'])) {
			echo '(already took an order... need to deliver first...)' . PHP_EOL;
		} elseif (empty($order)) {
			echo 'Excuse me, I couldn\'t hear your order.' . PHP_EOL;
		} elseif (array_search($order, $this->menu) !== false) {
			$this->orderProcess['orderItem'] = $order;
			echo "One order of {$this->orderProcess['orderItem']}." . PHP_EOL;
		} else {
			echo 'I\'m sorry. We don\'t serve that here.' . PHP_EOL;
		}
	}

	public function makeOrder()
	{
		if (is_null($this->orderProcess['orderItem'])) {
			echo '(need to take order first...)' . PHP_EOL;
		} elseif ($this->orderProcess['orderMade']) {
			echo '(order\'s already been made... need to deliver...)' . PHP_EOL;
		} else {
			echo 'Order up.' . PHP_EOL;
			$this->orderProcess['orderMade'] = true;
		}
	}

	public function deliverFood()
	{
		if (!$this->orderProcess['orderMade']) {
			echo '(order needs made first...)' . PHP_EOL;
		} else {
			echo "Here you are, one order of {$this->orderProcess['orderItem']}." . PHP_EOL;
			$this->orderProcess['orderItem'] = NULL;
			$this->orderProcess['orderMade'] = false;
			$this->orderProcess['tableDirty'] = true;
		}
	}

	public function cleanTable()
	{
		if (!$this->orderProcess['tableDirty']) {
			echo '(table\'s not dirty yet...)' . PHP_EOL;
		} else {
			echo '(table\'s all clean.)' . PHP_EOL;
			$this->orderProcess['tableDirty'] = false;
		}
	}

	public function info()
	{
		echo PHP_EOL . '----------------------------------------' . PHP_EOL . $this->name . PHP_EOL;
		echo 'Menu:' . PHP_EOL;
		foreach ($this->menu as $item) {
			echo "\t$item" . PHP_EOL;
		}
		echo 'Hours:' . PHP_EOL . "Open - {$this->hours['open']}" . PHP_EOL . "Close - {$this->hours['close']}" . PHP_EOL;
		echo 'Rating: ';
		for ($i = 0; $i < $this->rating; $i++) { 
			echo '*';
		}
		echo PHP_EOL . '----------------------------------------' . PHP_EOL . PHP_EOL;
	}

}
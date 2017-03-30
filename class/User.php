<?php

class User {

	public $username;
	public $email;
	public $password;
	public $date_created;

	public function returnUserInformation()
	{
		$userInfo = [
			'username' => $this->username,
			'email' => $this->email,
			'password' => $this->password,
			'date_created' => $this->date_created
		];

		return $userInfo;
	}
}
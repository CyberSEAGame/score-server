<?php

namespace Fuel\Tasks;

use Oil\Exception;

class User
{
	public static function createAdmin($username, $email, $password)
	{
		echo \Model_User::createAdmin($username, $email, $password);
	}
}
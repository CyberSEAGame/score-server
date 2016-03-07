<?php

class Model_Login extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'ip',
		'deleted_at' => [
			'default' => 0,
		],
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_belongs_to = array(
		'user' => array(
			'model_to' => 'Model_User',
			'key_from' => 'user_id',
			'key_to'   => 'id',
			'cascade_delete' => false,
		),
	);

	protected static $_table_name = 'logins';

	public static function loginLog($id)
	{
		$login = Model_Login::forge();
		$login->user_id = $id;
		$login->ip = Input::ip();
		$login->save();

		$login->user->csrf_token = md5(time() . $login->user->id . "asd234dfasd467");
		$login->user->save();
	}

}

<?php

namespace Fuel\Migrations;

class Add_csrf_token_to_users
{
	public function up()
	{
		\DBUtil::add_fields('users', array(
			'csrf_token' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('users', array(
			'csrf_token'

		));
	}
}
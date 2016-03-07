<?php

namespace Fuel\Migrations;

class Add_lock_time_to_users
{
	public function up()
	{
		\DBUtil::add_fields('users', array(
			'lock_time' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('users', array(
			'lock_time'

		));
	}
}
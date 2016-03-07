<?php

namespace Fuel\Migrations;

class Add_ip_to_logins
{
	public function up()
	{
		\DBUtil::add_fields('logins', array(
			'ip' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('logins', array(
			'ip'

		));
	}
}
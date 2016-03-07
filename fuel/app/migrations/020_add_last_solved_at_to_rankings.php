<?php

namespace Fuel\Migrations;

class Add_last_solved_at_to_rankings
{
	public function up()
	{
		\DBUtil::add_fields('rankings', array(
			'last_solved_at' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('rankings', array(
			'last_solved_at'

		));
	}
}
<?php

namespace Fuel\Migrations;

class Add_team_id_to_answerlogs
{
	public function up()
	{
		\DBUtil::add_fields('answerlogs', array(
			'team_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('answerlogs', array(
			'team_id'

		));
	}
}
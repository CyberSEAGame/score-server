<?php

namespace Fuel\Migrations;

class Create_rankings
{
	public function up()
	{
		\DBUtil::create_table('rankings', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'team_id' => array('constraint' => 11, 'type' => 'int'),
			'score' => array('constraint' => 11, 'type' => 'int'),
			'first_point' => array('constraint' => 11, 'type' => 'int'),
			'total_score' => array('constraint' => 11, 'type' => 'int'),
			'calculated_at' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('rankings');
	}
}
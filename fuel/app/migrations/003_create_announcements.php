<?php

namespace Fuel\Migrations;

class Create_announcements
{
	public function up()
	{
		\DBUtil::create_table('announcements', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'body' => array('type' => 'text'),
			'is_public' => array('constraint' => 1, 'type' => 'tinyint', 'default' => '0'),
			'public_at' => array('constraint' => 11, 'type' => 'int', 'default' => '0'),
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'default' => '0'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('announcements');
	}
}
<?php

namespace Fuel\Migrations;

class Add_is_solved_to_questions
{
	public function up()
	{
		\DBUtil::add_fields('questions', array(
			'is_solved' => array('constraint' => 1, 'type' => 'tinyint'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('questions', array(
			'is_solved'

		));
	}
}
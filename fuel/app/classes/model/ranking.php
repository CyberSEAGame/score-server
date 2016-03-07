<?php

class Model_Ranking extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'team_id',
		'score' => [
			'default' => 0,
		],
		'first_point' => [
			'default' => 0,
		],
		'total_score' => [
			'default' => 0,
		],
		'last_solved_at' => [
			'default' => 0,
		],
		'calculated_at',
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

	protected static $_table_name = 'rankings';

}

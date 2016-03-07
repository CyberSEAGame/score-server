<?php

class Model_Answerlog extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'question_id',
		'user_id',
		'team_id',
		'body',
		'is_corrected' => [
			'default' => 0,
		],
		'created_at',
		'updated_at',
	);

	protected static $_belongs_to = array(
		'user' => array(
			'model_to' => 'Model_User',
			'key_from' => 'user_id',
			'key_to'   => 'id',
			'cascade_delete' => false,
		),

		'question' => array(
			'model_to' => 'Model_Question',
			'key_from' => 'question_id',
			'key_to'   => 'id',
			'cascade_delete' => false,
		),

		'team' => array(
			'model_to' => 'Model_Team',
			'key_from' => 'team_id',
			'key_to'   => 'id',
			'cascade_delete' => false,
		),
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

	protected static $_table_name = 'answerlogs';

}

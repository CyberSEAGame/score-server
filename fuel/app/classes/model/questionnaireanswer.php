<?php

class Model_Questionnaireanswer extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'questionnaire_id',
		'body',
		'deleted_at' => [
			'default' => 0,
		],
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

	public function safeDelete()
	{
		$this->deleted_at = time();
		$this->save();
	}

	protected static $_table_name = 'questionnaireanswers';

}

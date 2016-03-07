<?php

class Model_Questionnaire extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title_id',
		'type_id',
		'body',
		'sort' => [
			'default' => 0,
		],
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

	public static function validate()
	{
		$val = Validation::forge();
		$val->add_field('title_id', 'title_id', 'required');
		$val->add_field('body', 'body', 'required');
		$val->add_field('type_id', 'type_id', 'required');
		return $val;
	}

	protected static $_belongs_to = array(
		'title' => array(
			'model_to' => 'Model_Questionnairetitle',
			'key_from' => 'title_id',
			'key_to'   => 'id',
			'cascade_delete' => false,
		)
	);

	protected static $_table_name = 'questionnaires';

}

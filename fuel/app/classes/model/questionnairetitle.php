<?php

class Model_Questionnairetitle extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
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

	protected static $_has_many = array(
		'questionnaires' => array(
			'model_to' => 'Model_Questionnaire',
			'key_from' => 'id',
			'key_to'   => 'title_id',
			'conditions' => array(
				'where' => array(array('deleted_at', 0)),
				'order_by' => array('sort' => 'desc'),
			),
		),
	);

	public static function validate()
	{
		$val = Validation::forge();
		$val->add_field('title', 'Title', 'required');
		return $val;
	}

	protected static $_table_name = 'questionnairetitles';

}

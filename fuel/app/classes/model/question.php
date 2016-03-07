<?php

class Model_Question extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'category_id' => [
			'default' => 0,
		],
		'title',
		'body',
		'point',
		'first_point',
		'is_opened' => [
			'default' => 0,
		],
		'is_solved' => [
			'default' => 0,
		],
		'answer',
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

	protected static $_belongs_to = array(
		'category' => array(
			'model_to' => 'Model_Category',
			'key_from' => 'category_id',
			'key_to'   => 'id',
			'cascade_delete' => false,
		)
	);

	protected static $_table_name = 'questions';

	public function safeDelete()
	{
		$this->deleted_at = time();
		$this->save();
	}

	public static function validate()
	{
		$val = Validation::forge();
		$val->add_field('title', 'title', 'required');
		$val->add_field('category_id', 'category_id', 'required');
		$val->add_field('body', 'body', 'required');
		$val->add_field('point', 'point', 'required');
		$val->add_field('first_point', 'first_point', 'required');
		$val->add_field('answer', 'answer', 'required');
		return $val;
	}

}

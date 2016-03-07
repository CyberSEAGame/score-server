<?php

class Model_Category extends \Orm\Model
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

	protected static $_table_name = 'categories';

	public static function validate()
	{
		$val = Validation::forge();
		$val->add_field('title', 'Title', 'required');
		return $val;
	}

	public function safeDelete()
	{
		$this->deleted_at = time();
		$this->save();
	}

}

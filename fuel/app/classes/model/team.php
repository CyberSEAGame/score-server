<?php

class Model_Team extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
		'color',
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

	protected static $_table_name = 'teams';

	public function safeDelete()
	{
		$this->deleted_at = time();
		$this->save();
	}

	public static function validate(){
		$val = Validation::forge();
		$val->add_field('name', 'name', 'required|max_length[100]');
		$val->add_field('color', 'Color', 'required|max_length[7]');
		return $val;
	}

	public function setRandColor()
	{
		static $chars = '0123456789ABCDEF';
		$this->color = '#';
		for ($i = 0; $i < 6; ++$i) {
			$this->color .= $chars[mt_rand(0, 15)];
		}
	}
}

<?php

class Model_Announcement extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
		'body',
		'is_public' => [
			'default' => 0,
		],
		'public_at' => [
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

	protected static $_table_name = 'announcements';

	public function safeDelete()
	{
		$this->deleted_at = time();
		$this->save();
	}

	public static function validate()
	{
		$val = Validation::forge();
		$val->add_field('title', 'Title', 'required|max_length[100]');
		$val->add_field('body', 'Body', 'required');
		$val->add('is_public', 'is_public');
		$val->add_field('public_at', 'public_at', 'required');
		return $val;
	}

	public function getPublicDatetime()
	{
		if($this->public_at == 0)
		{
			return "";
		}
		return date("m/d/Y H:i", $this->public_at);
	}

	public static function getNewest()
	{
		$announcement = Model_Announcement::find("first",[
			"where" => [
				["deleted_at", 0],
				["is_public", 1],
				["public_at", "<=", time()]
			],
			"order_by" => [
				["id", "desc"]
			]
		]);

		if($announcement == null)
		{
			return null;
		}

		return $announcement;
	}
}

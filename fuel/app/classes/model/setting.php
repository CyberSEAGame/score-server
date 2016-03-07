<?php

class Model_Setting extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'start_at' => [
			'default' => 0,
		],
		'finish_at' => [
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

	public function getStartDatetime()
	{
		return date("m/d/Y H:i", $this->start_at);
	}

	public function getFinishDatetime()
	{
		return date("m/d/Y H:i", $this->finish_at);
	}

	public static function checkTime()
	{
		$setting = Model_Setting::find("first");

		if($setting == null)
		{
			return false;
		}

		$time = time();
		if($setting->start_at >= $time)
		{
			return -1;
		}
		else if($setting->finish_at <= $time)
		{
			return -2;
		}

		return 0;
	}

	protected static $_table_name = 'settings';

}

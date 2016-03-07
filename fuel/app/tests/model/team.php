<?php
class Test_Model_Team extends \TestCase
{
	public function test_validation()
	{
		Fieldset::reset();

		$count = count(Model_Team::find("all", [
			["deleted_at", 0]
		]));

		$val = Model_Team::validate();

		$data = [
			'name' => 'test_team',
			'color' => '#ffffff'
		];

		if($val->run($data))
		{
			$input = $val->input();
			$team = Model_Team::forge();
			$team->name = $input["name"];
			$team->color = $input["color"];
			$team->save();
		}

		$update_count = count(Model_Team::find("all", [
			["deleted_at", 0]
		]));

		$this->assertEquals($count+1,$update_count);

		$team->delete();
	}
}
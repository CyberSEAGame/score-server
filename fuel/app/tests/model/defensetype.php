<?php
class Test_Model_Defensetype extends \TestCase
{
	public function test_validation()
	{
		Fieldset::reset();

		$count = count(Model_Defensetype::find("all", [
			["deleted_at", 0]
		]));

		$val = Model_Defensetype::validate();

		$data = [
			'name' => 'test',
			'point' => 10
		];

		if($val->run($data))
		{
			$input = $val->input();
			$def_type = Model_Defensetype::forge();
			$def_type->name = $input["name"];
			$def_type->point = $input["point"];
			$def_type->save();
		}

		$update_count = count(Model_Defensetype::find("all", [
			["deleted_at", 0]
		]));

		$this->assertEquals($count+1,$update_count);

		$def_type->delete();
	}
}
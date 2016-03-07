<?php
class Test_Model_Attacktype extends \TestCase
{
	public function test_validation()
	{
		Fieldset::reset();

		$count = count(Model_Attacktype::find("all", [
			["deleted_at", 0]
		]));

		$val = Model_Attacktype::validate();

		$data = [
			'name' => 'test',
			'point' => 10
		];

		if($val->run($data))
		{
			$input = $val->input();
			$atk_type = Model_Attacktype::forge();
			$atk_type->name = $input["name"];
			$atk_type->point = $input["point"];
			$atk_type->save();
		}

		$update_count = count(Model_Attacktype::find("all", [
			["deleted_at", 0]
		]));

		$this->assertEquals($count+1,$update_count);

		$atk_type	->delete();
	}
}
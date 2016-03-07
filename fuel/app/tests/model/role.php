<?php
class Test_Model_Role extends \TestCase
{
	public function test_validation()
	{
		Fieldset::reset();

		$count = count(Model_Role::find("all", [
			["deleted_at", 0]
		]));

		$val = Model_Role::validate();

		$data = [
			'body' => 'bodybody'
		];

		if($val->run($data))
		{
			$input = $val->input();
			$role = Model_Role::forge();
			$role->body = $input["body"];
			$role->save();
		}

		$update_count = count(Model_Role::find("all", [
			["deleted_at", 0]
		]));

		$this->assertEquals($count+1,$update_count);

		$role->delete();
	}
}
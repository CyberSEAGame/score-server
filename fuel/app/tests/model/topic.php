<?php
class Test_Model_Topic extends \TestCase
{
	public function test_validation()
	{
		Fieldset::reset();

		$count = count(Model_Topic::find("all", [
			["deleted_at", 0]
		]));

		$val = Model_Topic::validate();

		$data = [
			'title' => 'title',
			'body' => 'bodybody',
			'public_at' => '1432203563'
		];

		if($val->run($data))
		{
			$input = $val->input();
			$topic = Model_Topic::forge();
			$topic->title = $input["title"];
			$topic->body = $input["body"];
			$topic->save();
		}

		$update_count = count(Model_Topic::find("all", [
			["deleted_at", 0]
		]));

		$this->assertEquals($count+1,$update_count);

		$topic->delete();
	}
}
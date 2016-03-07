<?php
class Test_Model_User extends \TestCase
{
	public function test_admin()
	{
		$username = "aaatest";
		$email = "test@example.com";
		$password = "testtesttest";
		Model_User::createAdmin($username, $email, $password);
		$auth = Auth::instance();

		$auth->login($email, $password);

		$user_id = $auth->get_user_id()[1];
		$user = Model_User::find($user_id,[
			"where" => [
				["deleted_at", 0]
			]
		]);

		$this->assertEquals(100, $user->group_id);

		$user->delete();
	}
}
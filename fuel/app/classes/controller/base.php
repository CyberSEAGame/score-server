<?php


class Controller_Base extends Controller_Template
{
	public $auth = null;
	public $user = null;
	public $data = [];

	public function before()
	{

		parent::before();

		$this->auth = Auth::instance();

		// check login
		if(Auth::check())
		{
			$user_id = $this->auth->get_user_id()[1];

			$this->user = Model_User::find($user_id,[
				"where" => [
					["deleted_at", 0]
				]
			]);
		}
	}
}

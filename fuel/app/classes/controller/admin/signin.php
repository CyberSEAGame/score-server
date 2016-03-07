<?php

class Controller_Admin_Signin extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template = View::forge("admin/template");
		$this->template->is_signin = false;
	}

	public function action_index()
	{
		// login
		if(Input::post("email", null) !== null and Input::post("password", null) !== null and Security::check_token())
		{
			$email = Input::post('email', null);
			$password = Input::post('password', null);
			if($this->auth->login($email, $password))
			{
				Model_Login::loginLog($this->auth->get_user_id()[1]);
				Response::redirect('/admin');
			}
			else
			{
				Response::redirect('/admin/signin?error=1');
			}
		}

		$this->template->title = 'Signin';
		$this->template->content = View::forge('admin/signin', $this->data);
	}
}

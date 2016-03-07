<?php

class Controller_Setting extends Controller_User
{
	public function action_index()
	{
		if(!$this->template->is_signin)
		{
			Response::redirect(404);
		}

		$this->data["errors"] = [];

		$user = $this->template->user;

		if($user == null)
		{
			Response::redirect("404");
		}

		if(Input::post("username", null) !== null && Security::check_token())
		{
			$val = Model_User::validate();
			if($val->run())
			{
				$input = $val->input();

				if(!Model_User::checkEmail($input["email"]) && $user->email != $input["email"])
				{
					$this->data["errors"]["email"] = 1;
				}

				if(!Model_User::checkUsername($input["username"]) && $user->username != $input["username"])
				{
					$this->data["errors"]["username"] = 1;
				}

				if(count($this->data["errors"]) == 0)
				{
					$user->email = $input["email"];
					$user->username = $input["username"];

					if($input["password"] != null) $user->password = Auth::instance()->hash_password($input["password"]);

					$user->save();

					Response::redirect("/");
				}
			}
		}

		$this->data["username"] = $user["username"];
		$this->data["email"] = $user["email"];

		$this->template->title = 'Setting';
		$this->template->content = View::forge('setting', $this->data);
	}
}

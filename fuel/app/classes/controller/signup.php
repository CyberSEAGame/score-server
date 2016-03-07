<?php

class Controller_Signup extends Controller_User
{
	public function action_index()
	{
		$this->data["errors"] = [];

		$this->data["teams"] = Model_Team::find("all", [
			"where" => [
				["deleted_at", 0]
			]
		]);

		if(Input::post("username", null) !== null && Security::check_token())
		{
			$val = Model_User::validate();
			if($val->run())
			{
				$input = $val->input();

				if(!Model_User::checkEmail($input["email"]))
				{
					$this->data["errors"]["email"] = 1;
				}

				if(!Model_User::checkUsername($input["username"]))
				{
					$this->data["errors"]["username"] = 1;
				}

				if(count($this->data["errors"]) == 0)
				{
					$user_id = Model_User::createUser($input["username"],$input["email"],$input["password"]);
					$user = Model_User::find($user_id);
					$user->team_id = (int)$input["team_id"];
					$user->save();

					Response::redirect("/signin");
				}
			}
		}

		$this->data = array_merge($this->data, Input::post());

		$this->template->title = 'Signup';
		$this->template->content = View::forge('signup', $this->data);
	}
}

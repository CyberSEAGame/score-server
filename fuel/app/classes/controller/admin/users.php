<?php

class Controller_Admin_Users extends Controller_Admin
{

	public function action_index()
	{
		$count = Model_User::count([
			"where" => [
				["deleted_at", 0]
			]
		]);

		$config= [
			'pagination_url'=>"",
			'uri_segment'=>"p",
			'num_links'=>9,
			'per_page'=>20,
			'total_items'=>$count,
		];

		$this->data["pager"] = Pagination::forge('mypagination', $config);

		$this->data["users"] = Model_User::find("all", [
			"where" => [
				["deleted_at", 0]
			],
			"order_by" => [
				["id", "desc"]
			],
			"limit" => $this->data["pager"]->per_page,
			"offset" => $this->data["pager"]->offset

		]);

		$this->template->title = 'Users';
		$this->template->content = View::forge('admin/users/index', $this->data);
	}

	public function action_edit($id = 0)
	{
		$this->data["errors"] = [];

		$this->data["teams"] = Model_Team::find("all", [
			"where" => [
				["deleted_at", 0]
			]
		]);

		$user = Model_User::find($id, [
			"where" => [
				["deleted_at", 0]
			]
		]);

		if($user == null)
		{
			$user = Model_User::forge();
			$this->template->title = 'Create User';
		}
		else
		{
			$this->template->title = 'Update User';
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
					$user->group_id = (int)$input["group_id"];
					$user->team_id = (int)$input["team_id"];

					if($input["password"] != null) $user->password = Auth::instance()->hash_password($input["password"]);

					$user->save();

					Response::redirect("admin/users");
				}
			}
		}

		$this->data["username"] = Input::post("username", $user["username"]);
		$this->data["email"] = Input::post("email", $user["email"]);
		$this->data["group_id"] = Input::post("group_id", $user["group_id"]);
		$this->data["team_id"] = Input::post("team_id", $user["team_id"]);

		$this->template->content = View::forge('admin/users/form', $this->data);
	}
}

<?php

class Controller_Admin_Teams extends Controller_Admin
{

	public function action_index()
	{

		if(Security::check_token())
		{
			$delete_id = (int)Input::post("delete", 0);
			$delete = Model_Team::find($delete_id, [
				"where" => [
					["deleted_at", 0]
				]
			]);

			$delete->safeDelete();
		}

		$count = Model_Team::count([
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

		$this->data["teams"] = Model_Team::find("all", [
			"where" => [
				["deleted_at", 0]
			],
			"order_by" => [
				["id", "desc"]
			],
			"limit" => $this->data["pager"]->per_page,
			"offset" => $this->data["pager"]->offset

		]);

		$this->data['token'] = Security::fetch_token();

		$this->template->title = 'Teams';
		$this->template->content = View::forge('admin/teams/index', $this->data);
	}

	public function action_edit($id = 0)
	{
		$team = Model_Team::find($id, [
			"where" => [
				["deleted_at", 0]
			]
		]);

		if($team == null)
		{
			$team = Model_Team::forge();
			$team->setRandColor();
			$this->template->title = 'Create Team';
		}
		else
		{
			$this->template->title = 'Update Team';
		}

		if(Input::post("name", null) !== null && Security::check_token())
		{
			$val = Model_Team::validate();
			if($val->run())
			{
				$input = $val->input();
				$team->name = $input["name"];
				$team->color = $input["color"];
				$team->save();
			}

			Response::redirect("admin/teams");

		}

		$this->data["name"] = $team["name"];
		$this->data["color"] = $team["color"];

		$this->template->content = View::forge('admin/teams/form', $this->data);
	}
}

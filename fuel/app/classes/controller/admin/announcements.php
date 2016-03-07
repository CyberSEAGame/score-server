<?php

class Controller_Admin_Announcements extends Controller_Admin
{

	public function action_index()
	{
		$count = Model_Announcement::count([
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

		$this->data["announcements"] = Model_Announcement::find("all", [
			"where" => [
				["deleted_at", 0]
			],
			"order_by" => [
				["id", "desc"]
			],
			"limit" => $this->data["pager"]->per_page,
			"offset" => $this->data["pager"]->offset

		]);

		$this->template->title = 'Announcements';
		$this->template->content = View::forge('admin/announcements/index', $this->data);
	}

	public function action_edit($id = 0)
	{
		$announcement = Model_Announcement::find($id, [
			"where" => [
				["deleted_at", 0]
			]
		]);

		if($announcement == null)
		{
			$announcement = Model_Announcement::forge();

			$this->template->title = 'Create Announcement';
		}
		else
		{
			$this->template->title = 'Update Announcement';
		}

		if(Input::post("title", null) !== null && Security::check_token())
		{
			$val = Model_Announcement::validate();
			if($val->run())
			{
				$input = $val->input();
				$announcement->title = $input["title"];
				$announcement->body = $input["body"];
				$announcement->is_public = (int)$input["is_public"];
				$announcement->public_at = strtotime($input["public_at"] . ":00");
				$announcement->save();
			}

			Response::redirect("admin/announcements");

		}

		$this->data["title"] = $announcement["title"];
		$this->data["body"] = $announcement["body"];
		$this->data["is_public"] = $announcement["is_public"];
		$this->data["public_at"] = $announcement->getPublicDatetime();


		$this->template->content = View::forge('admin/announcements/form', $this->data);
	}
}

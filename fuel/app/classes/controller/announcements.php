<?php

class Controller_Announcements extends Controller_User
{
	public function action_index()
	{
		$count = Model_Announcement::count([
			"where" => [
				["deleted_at", 0],
				["is_public", 1],
				["public_at", "<=", time()]
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
				["deleted_at", 0],
				["is_public", 1],
				["public_at", "<=", time()]
			],
			"order_by" => [
				["id", "desc"]
			],
			"limit" => $this->data["pager"]->per_page,
			"offset" => $this->data["pager"]->offset

		]);

		$this->template->title = 'Announcements';
		$this->template->content = View::forge('announcements/index', $this->data);
	}

	public function action_detail($id = 0)
	{
		$this->data["announcement"] = Model_Announcement::find($id, [
			"where" => [
				["deleted_at", 0],
				["is_public", 1],
				["public_at", "<=", time()]
			],
		]);

		if($this->data["announcement"] == null)
		{
			Response::redirect(404);
		}

		$this->template->title = "{$this->data["announcement"]->title} (" . $this->data["announcement"]->getPublicDatetime() . ")";
		$this->template->content = View::forge('announcements/detail', $this->data);
	}
}

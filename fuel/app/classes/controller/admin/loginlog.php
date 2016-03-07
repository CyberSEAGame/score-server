<?php

class Controller_Admin_Loginlog extends Controller_Admin
{

	public function action_index()
	{
		$count = Model_Login::count([
			"where" => [
				["deleted_at", 0]
			]
		]);

		$config= [
			'pagination_url'=>"",
			'uri_segment'=>"p",
			'num_links'=>9,
			'per_page'=>100,
			'total_items'=>$count,
		];

		$this->data["pager"] = Pagination::forge('mypagination', $config);

		$this->data["logins"] = Model_Login::find("all", [
			"where" => [
				["deleted_at", 0]
			],
			"order_by" => [
				["id", "desc"]
			],
			"limit" => $this->data["pager"]->per_page,
			"offset" => $this->data["pager"]->offset

		]);

		$this->template->title = 'Login Log';
		$this->template->content = View::forge('admin/logins/index', $this->data);
	}

}

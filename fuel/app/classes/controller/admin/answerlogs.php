<?php

class Controller_Admin_Answerlogs extends Controller_Admin
{

	public function action_index()
	{
		$id = Input::get("id", 0);

		$question = Model_Question::find($id, [
			"where" => [
				["deleted_at", 0],
			]
		]);

		if($question == null)
		{
			Response::redirect("admin/");
		}

		$count = Model_Answerlog::count([
			"where" => [
				["question_id", $id]
			]
		]);

		$config= [
			'pagination_url'=>"?id={$id}",
			'uri_segment'=>"p",
			'num_links'=>9,
			'per_page'=>100,
			'total_items'=>$count,
		];

		$this->data["pager"] = Pagination::forge('mypagination', $config);

		$this->data["logs"] = Model_Answerlog::find("all", [
			"where" => [
				["question_id", $id]
			],
			"order_by" => [
				["id", "desc"]
			],
			"limit" => $this->data["pager"]->per_page,
			"offset" => $this->data["pager"]->offset

		]);

		$this->template->title = "Log({$question->title})";
		$this->template->content = View::forge('admin/answerlogs/index', $this->data);
	}

}

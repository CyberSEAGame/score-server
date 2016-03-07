<?php

class Controller_Admin_Questionnairetitles extends Controller_Admin
{

	public function action_index()
	{

		if(Input::post("sort", null) !== null && Security::check_token())
		{
			$title = Model_Questionnairetitle::find((int)Input::post("id", 0));
			$title->sort = (int)Input::post("sort", 0);
			$title->save();

		}

		$count = Model_Questionnairetitle::count([
			"where" => [
				["deleted_at", 0],
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

		$this->data["titles"] = Model_Questionnairetitle::find("all", [
			"where" => [
				["deleted_at", 0]
			],
			"order_by" => [
				["sort", "desc"],
				["id", "desc"]
			],
			"limit" => $this->data["pager"]->per_page,
			"offset" => $this->data["pager"]->offset

		]);

		$this->template->title = 'Questionnaire Titles';
		$this->template->content = View::forge('admin/questionnairetitles/index', $this->data);
	}

	public function action_edit($id = 0)
	{
		$title = Model_Questionnairetitle::find($id, [
			"where" => [
				["deleted_at", 0]
			]
		]);

		if($title == null)
		{
			$title = Model_Questionnairetitle::forge();
			$this->template->title = 'Create Questionnaire Title';
		}
		else
		{
			$this->template->title = 'Update Questionnaire Title';
		}

		if(Input::post("title", null) !== null && Security::check_token())
		{
			$val = Model_Questionnairetitle::validate();
			if($val->run())
			{
				$input = $val->input();
				$title->title = $input["title"];
				$title->save();
			}

			Response::redirect("admin/questionnairetitles");

		}

		$this->data["title"] = $title["title"];

		$this->template->content = View::forge('admin/questionnairetitles/form', $this->data);
	}
}

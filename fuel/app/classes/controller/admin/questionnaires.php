<?php

class Controller_Admin_Questionnaires extends Controller_Admin
{

	public function action_index()
	{

		if(Input::post("sort", null) !== null && Security::check_token())
		{
			$questionnaire = Model_Questionnaire::find((int)Input::post("id", 0));
			$questionnaire->sort = (int)Input::post("sort", 0);
			$questionnaire->save();

		}

		$count = Model_Questionnaire::count([
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

		$this->data["questionnaires"] = Model_Questionnaire::find("all", [
			"where" => [
				["deleted_at", 0]
			],
			"order_by" => [
				["title_id", "desc"],
				["sort", "desc"],
				["id", "desc"]
			],
			"limit" => $this->data["pager"]->per_page,
			"offset" => $this->data["pager"]->offset

		]);

		$this->template->title = 'Questionnaires';
		$this->template->content = View::forge('admin/questionnaires/index', $this->data);
	}

	public function action_edit($id = 0)
	{
		$questionnaire = Model_Questionnaire::find($id, [
			"where" => [
				["deleted_at", 0]
			]
		]);

		if($questionnaire == null)
		{
			$this->template->title = 'Create Questionnaire';
			$questionnaire = Model_Questionnaire::forge();
		}
		else
		{
			$this->template->title = 'Update Questionnaires';
		}

		if(Input::post("body", null) !== null && Security::check_token())
		{
			$val = Model_Questionnaire::validate();

			if($val->run())
			{
				$input = $val->input();
				$questionnaire->title_id = $input["title_id"];
				$questionnaire->type_id = $input["type_id"];
				$questionnaire->body = $input["body"];
				$questionnaire->save();
			}

			Response::redirect("admin/questionnaires");

		}

		$this->data["title_id"] = $questionnaire["title_id"];
		$this->data["type_id"] = $questionnaire["type_id"];
		$this->data["body"] = $questionnaire["body"];


		$this->data["titles"] = Model_Questionnairetitle::find("all", [
			"where" => [
				["deleted_at", 0]
			],
			"order_by" => [
				["sort", "desc"],
				["id", "desc"]
			],
		]);

		$this->template->content = View::forge('admin/questionnaires/form', $this->data);
	}
}

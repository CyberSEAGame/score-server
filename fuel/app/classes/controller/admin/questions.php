<?php

class Controller_Admin_Questions extends Controller_Admin
{

	public function action_index()
	{

		$query_text = <<<EOT
SELECT count(q.id) as c
FROM questions q
LEFT OUTER JOIN categories c
ON(q.category_id = c.id AND c.deleted_at = 0)
WHERE q.deleted_at = 0
EOT;

		$query = DB::query($query_text);

		$count = $query->execute()->as_array();

		if(isset($count[0]))
		{
			$count = $count[0]["c"];
		}
		else
		{
			$count = 0;
		}

		$config= [
			'pagination_url'=>"",
			'uri_segment'=>"p",
			'num_links'=>9,
			'per_page'=>50,
			'total_items'=>$count,
		];

		$pager = Pagination::forge('mypagination', $config);

		$query_text = <<<EOT
SELECT q.id,
       q.title,
       c.title as category,
       q.point,
       q.first_point,
       q.is_opened,
       q.is_solved
FROM questions q
LEFT OUTER JOIN categories c
ON(q.category_id = c.id AND c.deleted_at = 0)
WHERE q.deleted_at = 0
ORDER BY c.sort DESC, q.point ASC
LIMIT :offset,:limit
EOT;

		$query = DB::query($query_text);

		$offset = $pager->offset;
		$limit = $pager->per_page;
		$query->bind("offset", $offset);
		$query->bind("limit", $limit);

		$this->data["questions"] = $query->execute()->as_array();

		$this->data["pager"] = $pager;

		$this->template->title = 'Questions';
		$this->template->content = View::forge('admin/questions/index', $this->data);
	}

	public function action_edit($id = 0)
	{
		$question = Model_Question::find($id, [
			"where" => [
				["deleted_at", 0]
			]
		]);

		if($question == null)
		{
			$question = Model_Question::forge();
			$this->template->title = 'Create Question';
		}
		else
		{
			$this->template->title = 'Update Question';
		}

		if(Input::post("title", null) !== null && Security::check_token())
		{
			$val = Model_Question::validate();
			if($val->run())
			{
				$input = $val->input();
				$question->title = $input["title"];
				$question->category_id = $input["category_id"];
				$question->body = $input["body"];
				$question->point = $input["point"];
				$question->first_point = $input["first_point"];
				$question->answer = $input["answer"];
				$question->save();
			}

			Response::redirect("admin/questions");

		}

		$this->data["title"] = $question["title"];
		$this->data["category_id"] = $question["category_id"];
		$this->data["body"] = $question["body"];
		$this->data["point"] = $question["point"];
		$this->data["first_point"] = $question["first_point"];
		$this->data["answer"] = $question["answer"];

		$this->data["categories"] = Model_Category::find("all", [
			"where" => [
				["deleted_at", 0]
			]
		]);

		$this->template->content = View::forge('admin/questions/form', $this->data);
	}

	public function action_view($id = 0)
	{
		$this->data["question"] = Model_Question::find($id, [
			"where" => [
				["deleted_at", 0]
			]
		]);

		if($this->data["question"] == null)
		{
			Response::redirect("admin/questions");
		}

		$this->data["log"] = null;
		$this->data["user"] = $this->user;
		$this->data["status"] = null;

		if(Input::post("answer", null) != null && Input::post("csrf_token") == $this->user->csrf_token)
		{
			if($this->data["question"]->answer == Input::post("answer", null))
			{
				$this->data["status"] = 1;
			}
			else
			{
				$this->data["status"] = 2;
			}
		}


		$this->template->title = "{$this->data["question"]->title}({$this->data["question"]->category->title})";
		$this->template->content = View::forge('questions/detail', $this->data);
	}
}

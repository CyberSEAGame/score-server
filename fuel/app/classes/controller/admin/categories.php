<?php

class Controller_Admin_Categories extends Controller_Admin
{

	public function action_index()
	{

		if(Input::post("sort", null) !== null && Security::check_token())
		{
			$category = Model_Category::find((int)Input::post("id", 0));
			$category->sort = (int)Input::post("sort", 0);
			$category->save();

		}

		$query_text = <<<EOT
SELECT count(c.id) as c
FROM categories c
LEFT OUTER JOIN questions q
ON(q.category_id = c.id AND q.deleted_at = 0)
WHERE c.deleted_at = 0
GROUP BY c.id
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
			'per_page'=>20,
			'total_items'=>$count,
		];

		$pager = Pagination::forge('mypagination', $config);

		$query_text = <<<EOT
SELECT c.id,
       c.title,
       c.sort,
       count(q.id) as c
FROM categories c
LEFT OUTER JOIN questions q
ON(q.category_id = c.id AND q.deleted_at = 0)
WHERE c.deleted_at = 0
GROUP BY c.id
ORDER BY c.sort DESC
LIMIT :offset,:limit
EOT;

		$query = DB::query($query_text);

		$offset = $pager->offset;
		$limit = $pager->per_page;
		$query->bind("offset", $offset);
		$query->bind("limit", $limit);

		$this->data["categories"] = $query->execute()->as_array();

		$this->data["pager"] = $pager;

		$this->template->title = 'Categories';
		$this->template->content = View::forge('admin/categories/index', $this->data);
	}

	public function action_edit($id = 0)
	{
		$category = Model_Category::find($id, [
			"where" => [
				["deleted_at", 0]
			]
		]);

		if($category == null)
		{
			$category = Model_Category::forge();
			$this->template->title = 'Create Category';
		}
		else
		{
			$this->template->title = 'Update Category';
		}

		if(Input::post("title", null) !== null && Security::check_token())
		{
			$val = Model_Category::validate();
			if($val->run())
			{
				$input = $val->input();
				$category->title = $input["title"];
				$category->save();
			}

			Response::redirect("admin/categories");

		}

		$this->data["title"] = $category["title"];

		$this->template->content = View::forge('admin/categories/form', $this->data);
	}
}
